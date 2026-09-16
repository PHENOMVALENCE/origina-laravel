const header = document.querySelector('[data-site-header]');
const toggle = document.querySelector('[data-menu-toggle]');
const mobileNav = document.querySelector('[data-mobile-nav]');
const menuIcon = document.querySelector('[data-menu-icon]');

if (header && toggle && mobileNav) {
  const setMenuState = (open) => {
    toggle.setAttribute('aria-expanded', String(open));
    mobileNav.hidden = !open;
    document.documentElement.classList.toggle('menu-open', open);
    if (menuIcon) menuIcon.textContent = open ? 'Close' : 'Menu';
  };

  toggle.addEventListener('click', () => {
    setMenuState(toggle.getAttribute('aria-expanded') !== 'true');
  });

  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape' && toggle.getAttribute('aria-expanded') === 'true') {
      setMenuState(false);
      toggle.focus();
    }
  });

  mobileNav.addEventListener('click', (event) => {
    if (event.target.closest('a')) setMenuState(false);
  });
}
