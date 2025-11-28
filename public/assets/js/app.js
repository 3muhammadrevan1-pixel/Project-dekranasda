window.addEventListener('scroll', function() {
  const navbar = document.querySelector('.navbar-modern');
  if(window.scrollY > 50) navbar.classList.add('scrolled');
  else navbar.classList.remove('scrolled');

  // Highlight menu aktif
  const sections = document.querySelectorAll('section');
  const scrollPos = window.scrollY + 80;
  sections.forEach(section => {
    const id = section.getAttribute('id');
    const navLink = document.querySelector(`.nav-link[href="#${id}"]`);
    if(section.offsetTop <= scrollPos && (section.offsetTop + section.offsetHeight) > scrollPos) {
      document.querySelectorAll('.nav-link').forEach(link => link.classList.remove('active'));
      if(navLink) navLink.classList.add('active');
    }
  });
});

// Animasi masuk navbar saat load
window.addEventListener('load', function() {
  document.querySelector('.navbar-modern').classList.add('show');
});

// Smooth scroll
document.querySelectorAll('.nav-link, .dropdown-item').forEach(link => {
  link.addEventListener('click', function(e) {
    const targetSelector = this.getAttribute('href');
    if(targetSelector.startsWith('#')) {
      const target = document.querySelector(targetSelector);
      if(target) {
        e.preventDefault();
        window.scrollTo({
          top: target.offsetTop - 70,
          behavior: 'smooth'
        });
      }
    }
  });
});

document.querySelectorAll('.nav-item.dropdown').forEach(item => {
  const toggle = item.querySelector('.nav-link'); // atau tombol dropdown
  toggle.addEventListener('click', function(e) {
    e.preventDefault(); // supaya link ga langsung scroll
    item.classList.toggle('show');
  });
});

