<!-- Booking modal (Bootstrap) -->
<div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bookingModalLabel">Запись на услугу</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
            </div>
            <form method="POST" action="/booking" id="booking-form">
                @csrf
                <div class="modal-body">
                    <div id="booking-alert" style="display:none;" class="alert" role="alert"></div>
                    <div class="mb-3">
                        <label for="booking-name" class="form-label">Имя</label>
                        <input type="text" class="form-control" id="booking-name" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label for="booking-phone" class="form-label">Телефон</label>
                        <input type="tel" class="form-control" id="booking-phone" name="phone" inputmode="tel"
                               autocomplete="tel" placeholder="+7 (___) ___-__-__" required>
                    </div>

                    <div class="mb-3">
                        <label for="booking-service" class="form-label">Услуга</label>
                        <select class="form-select" id="booking-service" name="service_id" required>
                            <option value="" disabled selected>Выберите услугу</option>
                            @foreach($services ?? $_services as $s)
                                <option value="{{ $s->id }}">{{ $s->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <p class="helper-note">Мы свяжемся с вами сразу после получения заявки.</p>

                </div>
                <div class="modal-footer">
                    <!-- Убрана кнопка "Отмена" по требованию -->
                    <button type="submit" class="btn btn-primary" id="booking-submit" aria-label="Отправить заявку">
                        Отправить заявку
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
          var bookingModal = document.getElementById('bookingModal');
          if (!bookingModal) return;
          bookingModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget; // Button that triggered the modal
            var serviceId = '';
            if (button) {
              serviceId = button.getAttribute('data-bs-service') || button.getAttribute('data-service') || '';
            }
            var select = bookingModal.querySelector('#booking-service');
            if (select && serviceId) {
              // try to select option by id
              var opt = select.querySelector('option[value="' + serviceId + '"]');
              if (opt) {
                select.value = serviceId;
              }
            }

            // При открытии модалки убедимся, что поля видимы и alert скрыт
            try {
              bookingModal.querySelectorAll('.mb-3').forEach(function (el) { el.style.display = ''; });
              var footer = bookingModal.querySelector('.modal-footer');
              if (footer) footer.style.display = '';
              var alert = bookingModal.querySelector('#booking-alert');
              if (alert) { alert.style.display = 'none'; alert.className = 'alert'; alert.textContent = ''; }
            } catch (e) {
              // ignore
            }
          });

          // Восстановление видимости полей при полном закрытии модалки
          bookingModal.addEventListener('hidden.bs.modal', function () {
            try {
              bookingModal.querySelectorAll('.mb-3').forEach(function (el) { el.style.display = ''; });
              var footer = bookingModal.querySelector('.modal-footer');
              if (footer) footer.style.display = '';
              var alert = bookingModal.querySelector('#booking-alert');
              if (alert) { alert.style.display = 'none'; alert.className = 'alert'; alert.textContent = ''; }
              var submitBtn = bookingModal.querySelector('#booking-submit');
              if (submitBtn) { submitBtn.disabled = false; submitBtn.textContent = (submitBtn.dataset && submitBtn.dataset.originalText) ? submitBtn.dataset.originalText : 'Отправить заявку'; }
            } catch (e) {
              // ignore
            }
          });

          var bookingForm = document.getElementById('booking-form');
          var bookingAlert = document.getElementById('booking-alert');
          var phoneInput = document.getElementById('booking-phone');
          var submitBtn = document.getElementById('booking-submit');
          var bookingModalEl = document.getElementById('bookingModal');

          // NOTE: используем formatFromSubscriber ниже; старая formatRussianPhone удалена.

          function setCursorToEnd(el) {
            try { el.selectionStart = el.selectionEnd = el.value.length; } catch (e) {}
          }

          // Управляемая логика: храним subscriber-цифры (без кода страны) в data-digits
          if (phoneInput) {
            phoneInput.dataset.digits = phoneInput.dataset.digits || '';

            function formatFromSubscriber(subDigits) {
              // subDigits — строка до 10 цифр
              subDigits = (subDigits || '').replace(/\D/g, '').slice(0, 10);
              var digits = '7' + subDigits; // полная цифровая строка (11 цифр)
              if (!digits) return '';
              var out = '+' + digits.charAt(0);
              if (digits.length > 1) {
                out += ' (' + digits.substring(1, Math.min(4, digits.length));
                if (digits.length >= 4) out += ')';
                if (digits.length >= 4) out += ' ' + digits.substring(4, Math.min(7, digits.length));
                if (digits.length >= 7) out += '-' + digits.substring(7, Math.min(9, digits.length));
                if (digits.length >= 9) out += '-' + digits.substring(9, Math.min(11, digits.length));
              }
              return out;
            }

            // helper: получить позиции всех цифр в текущем value
            function getDigitPositions(text) {
              var pos = []; for (var i = 0; i < text.length; i++) if (/\d/.test(text.charAt(i))) pos.push(i); return pos;
            }

            // При фокусе — показываем префикс, не трогаем data-digits
            phoneInput.addEventListener('focus', function () {
              if (!phoneInput.value || phoneInput.value.trim() === '') {
                phoneInput.value = formatFromSubscriber(phoneInput.dataset.digits);
                // если пустые subscriber — покажем '+7 (' для UX
                if (!(phoneInput.dataset.digits || '').length) phoneInput.value = '+7 (';
                setCursorToEnd(phoneInput);
              }
            });

            phoneInput.addEventListener('blur', function () {
              if (!phoneInput.dataset.digits || phoneInput.dataset.digits === '') {
                phoneInput.value = '';
              }
            });

            // Обработка нажатий клавиш (ввод цифр, Backspace/Delete, навигация)
            phoneInput.addEventListener('keydown', function (e) {
              let isDigitKey = (e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 96 && e.keyCode <= 105);
              let navKeys = [9,13,37,38,39,40];

              // Вставка цифры — обрабатываем вручную чтобы не зависеть от символов форматирования
              if (isDigitKey) {
                e.preventDefault();
                var key = (e.keyCode >= 96) ? (e.keyCode - 48) : e.key;
                var digit = String(key).slice(-1);

                let text = phoneInput.value || '';
                let digitPositions = getDigitPositions(text);
                let caret = phoneInput.selectionStart;
                // количество цифр слева от каретки
                let countLeft = 0; for (let i = 0; i < digitPositions.length; i++) if (digitPositions[i] < caret) countLeft++;
                // subscriber index = countLeft - 1 (первый цифровой символ в отображении — код страны '7')
                var subIdx = Math.max(0, countLeft - 1);

                let sub = (phoneInput.dataset.digits || '').slice(0,10).split('');
                // если пользователь вводит первый символ '7' или '8' как первый — считаем его за первую цифру
                if (sub.length === 1 && sub[0] === '' ) sub = [];
                sub.splice(subIdx, 0, digit);
                sub = sub.join('').replace(/\D/g,'').slice(0,10);
                phoneInput.dataset.digits = sub;
                phoneInput.value = formatFromSubscriber(sub);
                setCursorToEnd(phoneInput);
                return;
              }

              // Backspace / Delete
              if (e.keyCode === 8 || e.keyCode === 46) {
                e.preventDefault();
                let text = phoneInput.value || '';
                let digitPositions = getDigitPositions(text);
                let caret = phoneInput.selectionStart;
                let selStart = phoneInput.selectionStart, selEnd = phoneInput.selectionEnd;

                let sub = (phoneInput.dataset.digits || '').split('');

                // helper: найти индекс цифры в digitPositions слева от caret (последняя позиция < caret)
                function findDigitIndexBefore(caretPos, digitPositionsArr) {
                  let idx = -1;
                  for (let i = 0; i < digitPositionsArr.length; i++) {
                    if (digitPositionsArr[i] < caretPos) idx = i;
                  }
                  return idx;
                }
                // helper: найти индекс цифры в digitPositions справа от caret (первый pos >= caret)
                function findDigitIndexAfter(caretPos, digitPositionsArr) {
                  for (let i = 0; i < digitPositionsArr.length; i++) if (digitPositionsArr[i] >= caretPos) return i;
                  return -1;
                }

                if (selStart !== selEnd) {
                  // удаляем все цифры, которые находятся в выделении
                  let newSub = [];
                  for (let j = 0; j < digitPositions.length; j++) {
                    let pos = digitPositions[j];
                    let subIndex = j - 1; // j=0 - код страны
                    if (subIndex < 0) continue;
                    if (pos < selStart || pos >= selEnd) newSub.push(sub[subIndex]);
                  }
                  sub = newSub;
                } else {
                  if (e.keyCode === 8) {
                    // Backspace: удаляем предыдущую цифру (последняя pos < caret)
                    let idx = findDigitIndexBefore(caret, digitPositions);
                    if (idx > 0) { // idx>0 означает не country code
                      let subIdx = idx - 1; sub.splice(subIdx, 1);
                    }
                  } else {
                    // Delete: удаляем следующую цифру (первый pos >= caret)
                    let idx2 = findDigitIndexAfter(caret, digitPositions);
                    if (idx2 > 0) { let subIdx2 = idx2 - 1; sub.splice(subIdx2, 1); }
                  }
                }

                let newSubStr = (sub || []).join('').replace(/\D/g,'').slice(0,10);
                phoneInput.dataset.digits = newSubStr;
                if (!newSubStr) {
                  phoneInput.value = '';
                  return;
                }
                phoneInput.value = formatFromSubscriber(newSubStr);
                setCursorToEnd(phoneInput);
                return;
              }

              // навигационные клавиши — разрешаем
              if (navKeys.indexOf(e.keyCode) !== -1) return;

              // всё остальное — запрещаем
              e.preventDefault();
            });

            // paste — вставляем цифры в позицию каретки
            phoneInput.addEventListener('paste', function (e) {
              e.preventDefault();
              let paste = (e.clipboardData || window.clipboardData).getData('text') || '';
              let pasteDigits = paste.replace(/\D/g, '');
              if (!pasteDigits) return;
              let text = phoneInput.value || '';
              let digitPositions = getDigitPositions(text);
              let caret = phoneInput.selectionStart;
              let countLeft = 0; for (let i = 0; i < digitPositions.length; i++) if (digitPositions[i] < caret) countLeft++;
              let subIdx = Math.max(0, countLeft - 1);
              let sub = (phoneInput.dataset.digits || '').split('');
              sub.splice(subIdx, 0, pasteDigits);
              let newSub = sub.join('').replace(/\D/g,'').slice(0,10);
              phoneInput.dataset.digits = newSub;
              phoneInput.value = formatFromSubscriber(newSub);
              setCursorToEnd(phoneInput);
            });
          }

          if (bookingForm) {
            // Сохраним оригинальный текст кнопки
            if (submitBtn && !submitBtn.dataset.originalText) submitBtn.dataset.originalText = submitBtn.textContent || 'Отправить заявку';

            bookingForm.addEventListener('submit', function (e) {
              e.preventDefault();
              if (!bookingAlert) return;
              bookingAlert.style.display = 'none';
              bookingAlert.className = 'alert';

              var formData = new FormData(bookingForm);
              if (submitBtn) submitBtn.disabled = true;
              var originalText = submitBtn ? submitBtn.textContent : '';
              if (submitBtn) submitBtn.textContent = 'Отправка...';

              fetch(bookingForm.action, {
                method: 'POST',
                headers: {
                  'X-Requested-With': 'XMLHttpRequest',
                  'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                  'Accept': 'application/json'
                },
                // Важно: отправляем куки сессии (Laravel сверяет токен с сессионным токеном)
                credentials: 'same-origin',
                body: formData,
              }).then(function (res) {
                return res.json().then(function (data) {
                  return { status: res.status, body: data };
                }).catch(function () {
                  return { status: res.status, body: null };
                });
              }).then(function (resp) {
                if (submitBtn) { submitBtn.disabled = false; submitBtn.textContent = originalText; }

                if (resp.status >= 200 && resp.status < 300 && resp.body && resp.body.status === 'ok') {
                  bookingAlert.classList.add('alert-success');
                  bookingAlert.textContent = resp.body.message || 'Ваша заявка принята.';
                  bookingAlert.style.display = 'block';

                  // скрываем поля формы и футер, оставляем только сообщение
                  try {
                    bookingModal.querySelectorAll('.mb-3').forEach(function (el) { el.style.display = 'none'; });
                    var footer = bookingModal.querySelector('.modal-footer');
                    if (footer) footer.style.display = 'none';
                  } catch (e) {
                    // ignore
                  }

                  // очистим форму и внутренние данные номера
                  try { if (phoneInput) phoneInput.dataset.digits = ''; } catch(e) {}
                  bookingForm.reset();

                  // автоматически закрываем модалку через 2.5 секунды (на 1s дольше)
                  try {
                    var bsModal = bootstrap.Modal.getInstance(bookingModalEl) || new bootstrap.Modal(bookingModalEl);
                    setTimeout(function () {
                      bsModal.hide();
                    }, 2500);
                  } catch (e) {
                    // ignore
                  }

                  return;
                }

                // обработка ошибок валидации
                if (resp.body && resp.body.errors) {
                  var msgs = [];
                  Object.keys(resp.body.errors).forEach(function (k) {
                    msgs.push(resp.body.errors[k].join('\n'));
                  });
                  bookingAlert.classList.add('alert-danger');
                  bookingAlert.textContent = msgs.join('\n');
                  bookingAlert.style.display = 'block';
                  return;
                }

                // прочие ошибки
                bookingAlert.classList.add('alert-danger');
                bookingAlert.textContent = (resp.body && resp.body.message) ? resp.body.message : 'Произошла ошибка. Попробуйте позже.';
                bookingAlert.style.display = 'block';
              }).catch(function () {
                if (submitBtn) { submitBtn.disabled = false; submitBtn.textContent = originalText; }
                bookingAlert.classList.add('alert-danger');
                bookingAlert.textContent = 'Сеть недоступна. Попробуйте позже.';
                bookingAlert.style.display = 'block';
              });
            });
          }
        });
    </script>
@endpush
