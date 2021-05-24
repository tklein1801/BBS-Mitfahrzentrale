class User {
  constructor() {
    this.apiHost = window.location.origin + "/api/user/";
    this.avatar = { size: 256, backgroundColor: "023846", color: "e27a00" };
  }

  /**
   * Get an image URL
   * @param {string} username
   * @returns {string}
   */
  getAvatarUrl(username) {
    return `https://eu.ui-avatars.com/api/?name=${username}&size=${this.avatar.size}&background=${this.avatar.backgroundColor}&color=${this.avatar.color}`;
  }

  /**
   * Register a new user. Before the data will be saved in the database we will check if the email is still avaiable
   * @param {string} name
   * @param {string} surname
   * @param {string} email
   * @param {string} password
   * @param {string} telNumber
   */
  async register(name, surname, email, password, telNumber) {
    const formData = new FormData();
    formData.append("name", name);
    formData.append("surname", surname);
    formData.append("email", email);
    formData.append("password", password);
    formData.append("telNumber", telNumber);
    const response = await fetch(this.apiHost + "register", {
      method: "POST",
      body: formData,
    });
    const data = await response.json();
    return data;
  }

  /**
   *
   * @param {string} apiKey
   * @param {string} password
   * @returns {object}
   */
  async setPassword(apiKey, password) {
    const form = new FormData();
    form.append("apiKey", apiKey);
    form.append("password", password);

    const response = await fetch(this.apiHost + "password/reset", {
      method: "POST",
      body: form,
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

  /**
   * UserId isn't required because the user is already signed in when the request is send
   * If the isn't signed in he won't be able to get information about his profile using this function
   */
  async get() {
    const response = await fetch(this.apiHost + "get", { method: "POST" });
    const data = await response.json();
    return data;
  }

  /**
   * UserId isn't required because the user is already signed in when the request is send
   * If the isn't signed in he won't be able to update his profile information
   * @param {string} phone
   * @param {string} password
   */
  async update(phone, password) {
    const formData = new FormData();
    formData.append("phone", phone);
    formData.append("password", password);

    const response = await fetch(this.apiHost + "update", {
      method: "POST",
      body: formData,
    });
    const data = await response.json();
    return data;
  }
}

class Mailer {
  constructor() {
    this.apiHost = window.location.origin + "/api/mail/";
  }

  /**
   *
   * @param {string} email
   * @return {boolean}
   */
  async requestPasswordReset(email) {
    const response = await fetch(this.apiHost + `reset_password?email=${email}`, {
      method: "GET",
    });
    const data = await response.text();
    return data;
  }
}

/**
 * Be aware that not every function from the User-class is compatible with the Admin-class
 */
class Admin {
  constructor() {
    this.apiHost = window.location.origin + "/api/admin/";
  }

  /**
   *
   * @param {number} userId
   * @returns {object}
   */
  async getUser(userId) {
    const form = new FormData();
    form.append("userId", userId);

    var response = await fetch(this.apiHost + "user/get", {
      method: "POST",
      body: form,
    });
    var data = await response.json();
    return data;
  }

  /**
   *
   * @param {number} userId
   * @param {number} isVerified
   * @param {number} isAdmin
   * @param {string} email
   * @param {string} phone
   * @param {string} password
   */
  async updateUser(userId, isVerified, isAdmin, name, surname, email, phone, password) {
    const form = new FormData();
    form.append("userId", userId);
    form.append("verified", isVerified);
    form.append("admin", isAdmin);
    form.append("name", name);
    form.append("surname", surname);
    form.append("email", email);
    form.append("phone", phone);
    form.append("password", password);

    var response = await fetch(this.apiHost + "user/update", {
      method: "POST",
      body: form,
    });
    var data = await response.json();
    return data;
  }

  /**
   *
   * @param {number} userId
   * @returns {[object]}
   */
  async getUserOffers(userId) {
    const form = new FormData();
    form.append("userId", userId);

    var response = await fetch(this.apiHost + "ride/user", {
      method: "POST",
      body: form,
    });
    var data = await response.json();
    return data;
  }

  /**
   *
   * @param {number} rideId
   */
  async getOffer(rideId) {
    const form = new FormData();
    form.append("rideId", rideId);

    var response = await fetch(this.apiHost + "ride/offer", {
      method: "POST",
      body: form,
    });
    var data = await response.json();
    return data;
  }

  /**
   * @param {number} rideId
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
  async updateOffer(
    rideId,
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
    form.append("rideId", rideId);
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

    var response = await fetch(this.apiHost + "ride/update", {
      method: "POST",
      body: form,
    });
    var data = await response.json();
    return data;
  }
}

class PLZ {
  constructor() {
    this.apiHost = window.location.origin + "/api/plz/";
  }

  /**
   * @param {number} plz
   */
  async placesByPlz(plz) {
    const response = await fetch(this.apiHost + `placesByPlz?plz=${plz}`, {
      method: "GET",
    });
    const data = await response.json();
    return data;
  }

  /**
   * @param {number} plz
   */
  async placeByPlz(plz) {
    const response = await fetch(this.apiHost + `placeByPlz?plz=${plz}`, {
      method: "GET",
    });
    const data = await response.json();
    return data;
  }

  /**
   * @param {string} cityName
   */
  async plzByPlace(cityName) {
    const response = await fetch(this.apiHost + `plzByName?cityName=${cityName}`, {
      method: "GET",
    });
    const data = await response.json();
    return data;
  }
}

class Ride {
  constructor() {
    this.apiHost = window.location.origin + "/api/ride/";
  }

  _renderOffer(offer) {
    const driver = offer.driver == 1 ? "Angebot" : "Gesuch";
    const seats = offer.seats > 1 ? `${offer.seats} Plätze` : `1 Platz`;
    const price = `${offer.price} €`;

    const now = new Date(),
      startAt = new Date(offer.startAt * 1000),
      createdAt = new Date(offer.createdAt * 1000);
    const createDate = {
      day:
        createdAt.getDate() == now.getDate()
          ? "Heute"
          : createdAt.getDate() == now.getDate() - 1
          ? "Gestern"
          : `${createdAt.getDate() > 9 ? createdAt.getDate() : `0${createdAt.getDate()}`}.${
              createdAt.getMonth() + 1 > 9
                ? createdAt.getMonth() + 1
                : `0${createdAt.getMonth() + 1}`
            }`,
      month:
        createdAt.getMonth() + 1 > 9 ? createdAt.getMonth() + 1 : `0${createdAt.getMonth() + 1}`,
      year: createdAt.getFullYear(),
      hours: createdAt.getHours() > 9 ? createdAt.getHours() : `0${createdAt.getHours()}`,
      minutes: createdAt.getMinutes() > 9 ? createdAt.getMinutes() : `0${createdAt.getMinutes()}`,
    };
    const startDate = {
      day: startAt.getDate() > 9 ? startAt.getDate() : `0${startAt.getDate()}`,
      month: startAt.getMonth() + 1 > 9 ? startAt.getMonth() + 1 : `0${startAt.getMonth() + 1}`,
      year: startAt.getFullYear(),
      hours: startAt.getHours() > 9 ? startAt.getHours() : `0${startAt.getHours()}`,
      minutes: startAt.getMinutes() > 9 ? startAt.getMinutes() : `0${startAt.getMinutes()}`,
    };

    return `<div id="offer-${offer.rideId}" class="card offer-card mb-3">
          <div class="row g-0">
            <div class="col-md-6">
              <div class="card-body">
                <a href="Angebot/${offer.rideId}" class="stretched-link text-white">
                  <h5 class="card-title">${offer.title}</h5>
                </a>
                <p class="card-text">${offer.information}</p>
                <p class="card-text">
                  <small class="text-muted">${createDate.day}, ${createDate.hours}:${createDate.minutes} Uhr</small>
                </p>
                <span class="badge bg-orange">${price}</span>
                <span class="badge bg-orange">${driver}</span>
                <span class="badge bg-orange">${seats}</span>
              </div>
            </div>
            <!-- ./1st-col -->
                    
            <div class="col-md-3 d-flex align-items-center">
              <div class="card-body">
                <p class="price">Start</p>
                <p>${startDate.day}.${startDate.month}.${startDate.year} • ${startDate.hours}:${startDate.minutes} Uhr</p>
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
  async update(
    rideId,
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
    form.append("rideId", rideId);
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

    const response = await fetch(this.apiHost + "update", {
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

  async getUserOffers() {
    const response = await fetch(this.apiHost + "user", {
      method: "GET",
    });
    const data = await response.json();
    return data;
  }

  /**
   * @param {number} rideId
   */
  async getOffer(rideId) {
    const response = await fetch(this.apiHost + `offer?rideId=${rideId}`, {
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
