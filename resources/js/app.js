const header = document.querySelector('[data-site-header]');
const toggle = document.querySelector('[data-menu-toggle]');
const mobileNav = document.querySelector('[data-mobile-nav]');
const menuIcon = document.querySelector('[data-menu-icon]');
const menuLabel = document.querySelector('[data-menu-label]');
const menuClose = document.querySelector('[data-menu-close]');
const desktopNav = document.querySelector('[data-desktop-nav]');

const closeDesktopPanels = (except = null) => {
  if (!desktopNav) return;

  desktopNav.querySelectorAll('[data-nav-item]').forEach((item) => {
    if (item === except) return;

    const trigger = item.querySelector('[data-nav-trigger]');
    const panel = item.querySelector('[data-nav-panel]');
    if (!trigger || !panel) return;

    trigger.setAttribute('aria-expanded', 'false');
    panel.hidden = true;
  });
};

if (desktopNav) {
  desktopNav.querySelectorAll('[data-nav-item]').forEach((item) => {
    const trigger = item.querySelector('[data-nav-trigger]');
    const panel = item.querySelector('[data-nav-panel]');
    if (!trigger || !panel) return;

    trigger.addEventListener('click', (event) => {
      event.stopPropagation();
      const opening = trigger.getAttribute('aria-expanded') !== 'true';
      closeDesktopPanels(item);
      trigger.setAttribute('aria-expanded', String(opening));
      panel.hidden = !opening;
    });
  });

  document.addEventListener('click', (event) => {
    if (!desktopNav.contains(event.target)) closeDesktopPanels();
  });
}

if (header && toggle && mobileNav) {
  const setMenuState = (open) => {
    toggle.setAttribute('aria-expanded', String(open));
    toggle.setAttribute('aria-label', open ? 'Close menu' : 'Open menu');
    mobileNav.hidden = !open;
    document.documentElement.classList.toggle('menu-open', open);
    document.body.style.overflow = open ? 'hidden' : '';

    if (menuIcon) menuIcon.textContent = open ? '✕' : '☰';
    if (menuLabel) menuLabel.textContent = open ? 'Close navigation' : 'Open navigation';
  };

  toggle.addEventListener('click', () => {
    setMenuState(toggle.getAttribute('aria-expanded') !== 'true');
  });

  if (menuClose) menuClose.addEventListener('click', () => {
    setMenuState(false);
    toggle.focus();
  });

  mobileNav.addEventListener('click', (event) => {
    if (event.target.closest('a')) setMenuState(false);
  });

  document.addEventListener('keydown', (event) => {
    if (event.key !== 'Escape') return;

    closeDesktopPanels();

    if (toggle.getAttribute('aria-expanded') === 'true') {
      setMenuState(false);
      toggle.focus();
    }
  });
}
