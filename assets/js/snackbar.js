class Snackbar {
  /**
   *
   * @param {string} text
   * @param {number} duration
   */
  constructor(text, duration = 5000) {
    this.text = text;
    this.duration = duration;
    this.closeText = "Ok";
  }

  exist() {
    return document.querySelector(".snackbar") !== null;
  }

  dismiss() {
    var dismiss = setInterval(() => {
      document.querySelector(".snackbar").classList.add("fadeOut");
      setTimeout(() => {
        document.querySelector(".snackbar").remove();
        clearInterval(dismiss);
      }, 1000);
    }, this.duration);

    document.querySelector(".snackbar .dismiss").addEventListener("click", function () {
      document.querySelector(".snackbar").classList.add("fadeOut");
      setTimeout(() => {
        document.querySelector(".snackbar").remove();
        clearInterval(dismiss);
      }, 1000);
    });
  }

  createSnackbar() {
    // <div class="snackbar bottom-right">
    //   <i class="snackbar-icon far fa-check-circle"></i>
    //   <p class="snackbar-text">${this.text}</p>
    //   <div class="button-container">
    //     <button class="dismiss">{this.closeText}</button>
    //   </div>
    // </div>

    var container = document.createElement("div");
    container.classList.add("snackbar", "bottom-right");
    var icon = document.createElement("i");
    icon.classList.add("snackbar-icon");
    var text = document.createElement("p");
    text.classList.add("snackbar-text");
    text.innerText = this.text;
    var btnContainer = document.createElement("div");
    btnContainer.classList.add("button-container");
    var dismissBtn = document.createElement("button");
    dismissBtn.classList.add("dismiss");
    dismissBtn.innerHTML = this.closeText.toUpperCase();

    btnContainer.appendChild(dismissBtn);
    container.appendChild(icon);
    container.appendChild(text);
    container.appendChild(btnContainer);
    document.body.appendChild(container);
  }

  success() {
    if (!this.exist()) {
      this.createSnackbar();
      document.querySelector(".snackbar").classList.add("snackbar-success");
      document.querySelector(".snackbar .snackbar-icon").classList.add("far", "fa-check-circle");
      this.dismiss();
    }
  }

  info() {
    if (!this.exist()) {
      this.createSnackbar();
      document.querySelector(".snackbar").classList.add("snackbar-info");
      document.querySelector(".snackbar .snackbar-icon").classList.add("fas", "fa-info-circle");
      this.dismiss();
    }
  }

  error() {
    if (!this.exist()) {
      this.createSnackbar();
      document.querySelector(".snackbar").classList.add("snackbar-error");
      document.querySelector(".snackbar .snackbar-icon").classList.add("far", "fa-times-circle");
      this.dismiss();
    }
  }
}
