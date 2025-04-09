<div class="container mt-1">
  <div class="row">
    <div class="col-md text-center fw-bold">Kontakti vorm</div>
    <div class="col-md text-center fw-bold">Minu andmed</div>
  </div>

  <div class="row m-3">
    <div class="col-md-6">
      <form>
        <div class="mb-3">
          <label for="name" class="form-label">Nimi <span class="text-danger">*</span></label>
          <input
            type="text"
            class="form-control"
            id="name"
            required
            placeholder="Sisesta oma nimi või hüüdnimi" />
        </div>

        <div class="mb-3">
          <label for="email" class="form-label">E-post <span class="text-danger">*</span></label>
          <input
            type="email"
            class="form-control"
            id="email"
            required
            placeholder="Sisesta oma e-posti aadress" />
        </div>

        <div class="mb-3">
          <label for="message" class="form-label">Sõnum <span class="text-danger">*</span></label>
          <textarea
            class="form-control"
            id="message"
            rows="5"
            required
            placeholder="Kirjuta oma küsimus või tagasiside"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Saada</button>
      </form>
    </div>

    <div class="col-md-6">
      <p><strong>Nimi:</strong> Kauri Blogi</p>
      <p>
        <strong>E-post:</strong>
        <a href="mailto:kauri@blogi.ee">kauri@blogi.ee</a>
      </p>
      <p><strong>Sotsiaalmeedia:</strong></p>
      <ul class="list-unstyled">
        <li>
          <a href="https://facebook.com/kauriblogi" target="_blank">Facebook</a>
        </li>
        <li>
          <a href="https://instagram.com/kauriblogi" target="_blank">Instagram</a>
        </li>
        <li>
          <a href="https://linkedin.com/in/kauriblogi" target="_blank">LinkedIn</a>
        </li>
      </ul>
    </div>
  </div>
</div>