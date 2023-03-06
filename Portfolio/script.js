window.addEventListener('scroll', function() {
    const scrollPosition = document.documentElement.scrollTop;
    const windowHeight = document.documentElement.clientHeight;
    const fullHeight = document.documentElement.scrollHeight;
    const scrolled = (scrollPosition / (fullHeight - windowHeight)) * 100;
    document.getElementById('progressBar').style.width = scrolled + '%';
  });
  
  window.addEventListener('scroll', function() {
    const scrollPosition = document.documentElement.scrollTop;
    const windowHeight = document.documentElement.clientHeight;
    const fullHeight = document.documentElement.scrollHeight;
    const scrolled = (scrollPosition / (fullHeight - windowHeight)) * 100;
    document.getElementById('progressBar2').style.width = scrolled + '%';
  });

const downloadLinks = document.querySelectorAll("[data-download]");

  downloadLinks.forEach(button =>{
      const id = button.dataset.download;
      const image = document.getElementById(id);
      const a = document.createElement("a");

      a.href = imgage.src;
      a.download = "";
      a.style.display = "none";
  })