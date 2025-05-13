// header
fetch("./components/header.html")
    .then(response => response.text())
    .then(data => {
      document.getElementById("header").innerHTML = data;
    });

// about
fetch("./components/about.html")
    .then(response => response.text())
    .then(data => {
      document.getElementById("about").innerHTML = data;
    });

// features
fetch("./components/features.html")
    .then(response => response.text())
    .then(data => {
      document.getElementById("features").innerHTML = data;
    });

// collections
fetch("./components/collections.html")
    .then(response => response.text())
    .then(data => {
      document.getElementById("collections").innerHTML = data;
    });

// kalamkari
fetch("./components/kalamkari.html")
    .then(response => response.text())
    .then(data => {
      document.getElementById("kalamkari").innerHTML = data;
    });

// kanjivaram
fetch("./components/kanjivaram.html")
    .then(response => response.text())
    .then(data => {
      document.getElementById("kanjivaram").innerHTML = data;
    });




// footer
fetch("./components/footer.html")
    .then(response => response.text())
    .then(data => {
      document.getElementById("footer").innerHTML = data;
    });
