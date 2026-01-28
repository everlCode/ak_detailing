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
            <label for="booking-service" class="form-label">Услуга</label>
            @php $_services = \App\Models\Service::all(); @endphp
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
          <button type="submit" class="btn btn-primary" id="booking-submit" aria-label="Отправить заявку">Отправить заявку</button>
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
    var submitBtn = document.getElementById('booking-submit');
    var bookingModalEl = document.getElementById('bookingModal');

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

            // очистим форму
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
        }).catch(function (err) {
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
