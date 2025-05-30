document.addEventListener('DOMContentLoaded', () => {
  // Load header
  fetch("./components/header.html")
    .then(response => response.text())
    .then(data => {
      const header = document.getElementById("header");
      if (header) header.innerHTML = data;
      else console.warn("#header element not found");
    });

  // Load about
  fetch("./components/about.html")
    .then(response => response.text())
    .then(data => {
      const about = document.getElementById("about");
      if (about) about.innerHTML = data;
      else console.warn("#about element not found");
    });

  // Load features
  fetch("./components/features.html")
    .then(response => response.text())
    .then(data => {
      const features = document.getElementById("features");
      if (features) features.innerHTML = data;
      else console.warn("#features element not found");
    });

  // Load collections
  fetch("./components/collections.html")
    .then(response => response.text())
    .then(data => {
      const collections = document.getElementById("collections");
      if (collections) collections.innerHTML = data;
      else console.warn("#collections element not found");
    });

  // Load footer
  fetch("./components/footer.html")
    .then(response => response.text())
    .then(data => {
      const footer = document.getElementById("footer");
      if (footer) footer.innerHTML = data;
      else console.warn("#footer element not found");
    });
});
