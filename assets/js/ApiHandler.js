class User {
  constructor() {
    this.apiHost = window.location.origin + "/api/user/";
  }

  /**
   * Register a new user. Before the data will be saved in the database we will check if the email is still avaiable
   * @param {string} name
   * @param {string} surname
   * @param {string} email
   * @param {string} password
   * @param {string} adress
   * @param {number} plz
   * @param {string} place
   * @param {string} telNumber
   */
  async register(name, surname, email, password, adress, plz, place, telNumber) {
    const formData = new FormData();
    formData.append("name", name);
    formData.append("surname", surname);
    formData.append("email", email);
    formData.append("password", password);
    formData.append("adress", adress);
    formData.append("plz", plz);
    formData.append("place", place);
    formData.append("telNumber", telNumber);

    const response = await fetch(this.apiHost + "register", {
      method: "POST",
      body: formData,
    });
    const data = await response.json();
    return data;
  }

  /**
   * Check if the login-credentials are correct
   * If they are correct the will be signed in automaticly
   * @param {string} email
   * @param {string} password
   */
  async checkCredentials(email, password) {
    const response = await fetch(
      this.apiHost + `checkCredentials?email=${email}&password=${password}`,
      { method: "GET" }
    );
    const data = await response.json();
    return data;
  }

  /**
   * Destroys the current user session
   */
  async destroySession() {
    await fetch(this.apiHost + `destroySession`, { method: "GET" });
  }

  /**
   * Check if the username/email is still avaiable or not
   * @param {string} email
   */
  async exist(email) {
    const response = await fetch(this.apiHost + `exist?email=${email}`, { method: "GET" });
    const data = await response.json();
    return data;
  }
}

class Ride {
  constructor() {
    this.apiHost = window.location.origin + "/api/ride/";
  }

  _renderOffer(offer) {
    const today = new Date(),
      createdAt = parseInt(offer.createdAt * 1000), // convert timestamp(in secs) to timestamp(in millis) for JavaScript
      createDate = new Date(createdAt),
      createDay =
        createDate.getDate() == today.getDate()
          ? "Heute"
          : createDate.getDate() == today.getDate() - 1
          ? "Gestern"
          : `${createDate.getDate() > 9 ? createDate.getDate() : `0${createDate.getDate()}`}.${
              createDate.getMonth() + 1 > 9
                ? createDate.getMonth() + 1
                : `0${createDate.getMonth() + 1}`
            }`,
      createHours = createDate.getHours() > 9 ? createDate.getHours() : `0${createDate.getHours()}`,
      createMinutes =
        createDate.getMinutes() > 9 ? createDate.getMinutes() : `0${createDate.getMinutes()}`;
    return `<div id="offer-${offer.rideId}" class="card offer-card mb-3">
                  <div class="row g-0">
                    <div class="col-md-6">
                      <div class="card-body">
                        <a href="Angebot/${offer.rideId}" class="stretched-link text-white">
                          <h5 class="card-title">${offer.title}</h5>
                        </a>
                        <!-- <h5 class="card-title">Card title</h5> -->
                        <p class="card-text">
                          ${offer.information}
                        </p>
                        <p class="card-text">
                          <small class="text-muted">${createDay}, ${createHours}:${createMinutes} Uhr</small>
                        </p>
                        <span class="badge bg-orange">${offer.price} €</span>
                        <span class="badge bg-orange">${
                          offer.driver == "1" ? "Angebot" : "Gesuch"
                        }</span>
                      </div>
                    </div>
                    <!-- ./1st-col -->
                    <div class="col-md-3 d-flex align-items-center">
                      <div class="card-body">
                        <p class="price">Start</p>
                        <p>
                          ${offer.startPlz} ${offer.startCity} <br />
                          ${offer.startAdress}
                        </p>
                      </div>
                    </div>
                    <!-- ./2nd-col -->
                    <div class="col-md-3 d-flex align-items-center">
                      <div class="card-body">
                        <p class="price">Ziel</p>
                        <p>
                          ${offer.destinationPlz} ${offer.destinationCity} <br />
                          ${offer.destinationAdress}
                        </p>
                      </div>
                    </div>
                    <!-- ./3rd-col -->
                  </div>
                  <!-- ./row -->
                </div>`;
  }

  /**
   * @param {number} driver
   * @param {string} title
   * @param {string} information
   * @param {number} price
   * @param {number} seats
   * @param {number} startAt
   * @param {number} startPlz
   * @param {string} startCity
   * @param {string} startAdress
   * @param {number} destinationPlz
   * @param {string} destinationCity
   * @param {string} destinationAdress
   */
  async create(
    driver,
    title,
    information,
    price,
    seats,
    startAt,
    startPlz,
    startCity,
    startAdress,
    destinationPlz,
    destinationCity,
    destinationAdress
  ) {
    const form = new FormData();
    form.append("driver", driver);
    form.append("title", title);
    form.append("information", information);
    form.append("price", price);
    form.append("seats", seats);
    form.append("startAt", startAt);
    form.append("startPlz", startPlz);
    form.append("startCity", startCity);
    form.append("startAdress", startAdress);
    form.append("destinationPlz", destinationPlz);
    form.append("destinationCity", destinationCity);
    form.append("destinationAdress", destinationAdress);

    const response = await fetch(this.apiHost + "create", {
      method: "POST",
      body: form,
    });
    const data = await response.json();
    return data;
  }

  /**
   * @param {number} rideId
   */
  async delete(rideId) {
    const form = new FormData();
    form.append("rideId", rideId);

    const response = await fetch(this.apiHost + "delete", {
      method: "POST",
      body: form,
    });
    const data = await response.json();
    return data;
  }

  async getAll() {
    const response = await fetch(this.apiHost + "all", {
      method: "GET",
    });
    const data = await response.json();
    return data;
  }

  async getFavorites() {
    const response = await fetch(this.apiHost + "favorites", {
      method: "GET",
    });
    const data = await response.json();
    return data;
  }

  /**
   * @param {*} rideId
   */
  async getOffer(rideId) {
    const response = await fetch(this.apiHost + `all?rideId=${rideId}`, {
      method: "GET",
    });
    const data = await response.json();
    return data;
  }

  async getOffers() {
    const response = await fetch(this.apiHost + "offers", {
      method: "GET",
    });
    const data = await response.json();
    return data;
  }

  async getRequests() {
    const response = await fetch(this.apiHost + "requests", {
      method: "GET",
    });
    const data = await response.json();
    return data;
  }
}
