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
