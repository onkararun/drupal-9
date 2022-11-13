/**
 * @file
 * JavaScript behaviors for jQuery Text Counter integration.
 */

(function ($, Drupal) {

  'use strict';

  // @see https://github.com/ractoon/jQuery-Text-Counter#options
  Drupal.webform = Drupal.webform || {};
  Drupal.webform.counter = Drupal.webform.counter || {};
  Drupal.webform.counter.options = Drupal.webform.counter.options || {};

  /**
   * Initialize text field and textarea word and character counter.
   *
   * @type {Drupal~behavior}
   */
  Drupal.behaviors.webformCounter = {
    attach: function (context) {
      if (!$.fn.textcounter) {
        return;
      }

      $(context).find('.js-webform-counter').once('webform-counter').each(function () {
        var options = {
          type: $(this).data('counter-type'),
          max: $(this).data('counter-maximum'),
          min: $(this).data('counter-minimum') || 0,
          counterText: $(this).data('counter-minimum-message'),
          countDownText: $(this).data('counter-maximum-message'),
          inputErrorClass: 'webform-counter-warning',
          counterErrorClass: 'webform-counter-warning',
          countSpaces: true,
          twoCharCarriageReturn: true,
          stopInputAtMaximum: false,
          // Don't display min/max message since server-side validation will
          // display these messages.
          minimumErrorText: '',
          maximumErrorText: ''
        };

        options.countDown = (options.max) ? true : false;
        if (!options.counterText) {
          options.counterText = (options.type === 'word') ? Drupal.t('%d word(s) entered') : Drupal.t('%d character(s) entered');
        }
        if (!options.countDownText) {
          options.countDownText = (options.type === 'word') ? Drupal.t('%d word(s) remaining') : Drupal.t('%d character(s) remaining');
        }

        options = $.extend(options, Drupal.webform.counter.options);

        $(this).textcounter(options);
      });

    }
  };

})(jQuery, Drupal);
;
/**
 * @file
 * JavaScript behaviors for select menu.
 */

(function ($, Drupal) {

  'use strict';

  /**
   * Disable select menu options using JavaScript.
   *
   * @type {Drupal~behavior}
   */
  Drupal.behaviors.webformSelectOptionsDisabled = {
    attach: function (context) {
      $('select[data-webform-select-options-disabled]', context).once('webform-select-options-disabled').each(function () {
        var $select = $(this);
        var disabled = $select.attr('data-webform-select-options-disabled').split(/\s*,\s*/);
        $select.find('option').filter(function isDisabled() {
          return ($.inArray(this.value, disabled) !== -1);
        }).attr('disabled', 'disabled');
      });
    }
  };

})(jQuery, Drupal);
;
/**
* DO NOT EDIT THIS FILE.
* See the following change record for more information,
* https://www.drupal.org/node/2815083
* @preserve
**/

(function (Drupal) {
  var searchWideButtonSelector = '[data-drupal-selector="block-search-wide-button"]';
  var searchWideButton = document.querySelector(searchWideButtonSelector);
  var searchWideWrapperSelector = '[data-drupal-selector="block-search-wide-wrapper"]';
  var searchWideWrapper = document.querySelector(searchWideWrapperSelector);

  function searchIsVisible() {
    return searchWideWrapper.classList.contains('is-active');
  }

  Drupal.olivero.searchIsVisible = searchIsVisible;

  function watchForClickOut(e) {
    var clickInSearchArea = e.target.matches("\n      ".concat(searchWideWrapperSelector, ",\n      ").concat(searchWideWrapperSelector, " *,\n      ").concat(searchWideButtonSelector, ",\n      ").concat(searchWideButtonSelector, " *\n    "));

    if (!clickInSearchArea && searchIsVisible()) {
      toggleSearchVisibility(false);
    }
  }

  function watchForFocusOut(e) {
    if (e.relatedTarget) {
      var inSearchBar = e.relatedTarget.matches("".concat(searchWideWrapperSelector, ", ").concat(searchWideWrapperSelector, " *"));
      var inSearchButton = e.relatedTarget.matches("".concat(searchWideButtonSelector, ", ").concat(searchWideButtonSelector, " *"));

      if (!inSearchBar && !inSearchButton) {
        toggleSearchVisibility(false);
      }
    }
  }

  function watchForEscapeOut(e) {
    if (e.key === 'Escape' || e.key === 'Esc') {
      toggleSearchVisibility(false);
    }
  }

  function handleFocus() {
    if (searchIsVisible()) {
      searchWideWrapper.querySelector('input[type="search"]').focus();
    } else if (searchWideWrapper.contains(document.activeElement)) {
      searchWideButton.focus();
    }
  }

  function toggleSearchVisibility(visibility) {
    searchWideButton.setAttribute('aria-expanded', visibility === true);
    searchWideWrapper.addEventListener('transitionend', handleFocus, {
      once: true
    });

    if (visibility === true) {
      Drupal.olivero.closeAllSubNav();
      searchWideWrapper.classList.add('is-active');
      document.addEventListener('click', watchForClickOut, {
        capture: true
      });
      document.addEventListener('focusout', watchForFocusOut, {
        capture: true
      });
      document.addEventListener('keyup', watchForEscapeOut, {
        capture: true
      });
    } else {
      searchWideWrapper.classList.remove('is-active');
      document.removeEventListener('click', watchForClickOut, {
        capture: true
      });
      document.removeEventListener('focusout', watchForFocusOut, {
        capture: true
      });
      document.removeEventListener('keyup', watchForEscapeOut, {
        capture: true
      });
    }
  }

  Drupal.olivero.toggleSearchVisibility = toggleSearchVisibility;
  Drupal.behaviors.searchWide = {
    attach: function attach(context) {
      var searchWideButtonEl = once('search-wide', searchWideButtonSelector, context).shift();

      if (searchWideButtonEl) {
        searchWideButtonEl.setAttribute('aria-expanded', searchIsVisible());
        searchWideButtonEl.addEventListener('click', function () {
          toggleSearchVisibility(!searchIsVisible());
        });
      }
    }
  };
})(Drupal);;
/**
* DO NOT EDIT THIS FILE.
* See the following change record for more information,
* https://www.drupal.org/node/2815083
* @preserve
**/

(function (Drupal, once, tabbable) {
  function isNavOpen(navWrapper) {
    return navWrapper.classList.contains('is-active');
  }

  function toggleNav(props, state) {
    var value = !!state;
    props.navButton.setAttribute('aria-expanded', value);

    if (value) {
      props.body.classList.add('is-overlay-active');
      props.body.classList.add('is-fixed');
      props.navWrapper.classList.add('is-active');
    } else {
      props.body.classList.remove('is-overlay-active');
      props.body.classList.remove('is-fixed');
      props.navWrapper.classList.remove('is-active');
    }
  }

  function init(props) {
    props.navButton.setAttribute('aria-controls', props.navWrapperId);
    props.navButton.setAttribute('aria-expanded', 'false');
    props.navButton.addEventListener('click', function () {
      toggleNav(props, !isNavOpen(props.navWrapper));
    });
    document.addEventListener('keyup', function (e) {
      if (e.key === 'Escape' || e.key === 'Esc') {
        if (props.olivero.areAnySubNavsOpen()) {
          props.olivero.closeAllSubNav();
        } else {
          toggleNav(props, false);
        }
      }
    });
    props.overlay.addEventListener('click', function () {
      toggleNav(props, false);
    });
    props.overlay.addEventListener('touchstart', function () {
      toggleNav(props, false);
    });
    props.header.addEventListener('keydown', function (e) {
      if (e.key === 'Tab' && isNavOpen(props.navWrapper)) {
        var tabbableNavElements = tabbable.tabbable(props.navWrapper);
        tabbableNavElements.unshift(props.navButton);
        var firstTabbableEl = tabbableNavElements[0];
        var lastTabbableEl = tabbableNavElements[tabbableNavElements.length - 1];

        if (e.shiftKey) {
          if (document.activeElement === firstTabbableEl && !props.olivero.isDesktopNav()) {
            lastTabbableEl.focus();
            e.preventDefault();
          }
        } else if (document.activeElement === lastTabbableEl && !props.olivero.isDesktopNav()) {
          firstTabbableEl.focus();
          e.preventDefault();
        }
      }
    });
    window.addEventListener('resize', function () {
      if (props.olivero.isDesktopNav()) {
        toggleNav(props, false);
        props.body.classList.remove('is-overlay-active');
        props.body.classList.remove('is-fixed');
      }

      Drupal.olivero.closeAllSubNav();
    });
    props.navWrapper.addEventListener('click', function (e) {
      if (e.target.matches("[href*=\"".concat(window.location.pathname, "#\"], [href*=\"").concat(window.location.pathname, "#\"] *, [href^=\"#\"], [href^=\"#\"] *"))) {
        toggleNav(props, false);
      }
    });
  }

  Drupal.behaviors.oliveroNavigation = {
    attach: function attach(context) {
      var headerId = 'header';
      var header = once('navigation', "#".concat(headerId), context).shift();
      var navWrapperId = 'header-nav';

      if (header) {
        var navWrapper = header.querySelector("#".concat(navWrapperId));
        var olivero = Drupal.olivero;
        var navButton = context.querySelector('[data-drupal-selector="mobile-nav-button"]');
        var body = context.querySelector('body');
        var overlay = context.querySelector('[data-drupal-selector="header-nav-overlay"]');
        init({
          olivero: olivero,
          header: header,
          navWrapperId: navWrapperId,
          navWrapper: navWrapper,
          navButton: navButton,
          body: body,
          overlay: overlay
        });
      }
    }
  };
})(Drupal, once, tabbable);;
/**
* DO NOT EDIT THIS FILE.
* See the following change record for more information,
* https://www.drupal.org/node/2815083
* @preserve
**/

(function (Drupal) {
  var isDesktopNav = Drupal.olivero.isDesktopNav;
  var secondLevelNavMenus = document.querySelectorAll('[data-drupal-selector="primary-nav-menu-item-has-children"]');

  function toggleSubNav(topLevelMenuItem, toState) {
    var buttonSelector = '[data-drupal-selector="primary-nav-submenu-toggle-button"]';
    var button = topLevelMenuItem.querySelector(buttonSelector);
    var state = toState !== undefined ? toState : button.getAttribute('aria-expanded') !== 'true';

    if (state) {
      if (isDesktopNav()) {
        secondLevelNavMenus.forEach(function (el) {
          el.querySelector(buttonSelector).setAttribute('aria-expanded', 'false');
          el.querySelector('[data-drupal-selector="primary-nav-menu--level-2"]').classList.remove('is-active-menu-parent');
          el.querySelector('[data-drupal-selector="primary-nav-menu-🥕"]').classList.remove('is-active-menu-parent');
        });
      }

      button.setAttribute('aria-expanded', 'true');
      topLevelMenuItem.querySelector('[data-drupal-selector="primary-nav-menu--level-2"]').classList.add('is-active-menu-parent');
      topLevelMenuItem.querySelector('[data-drupal-selector="primary-nav-menu-🥕"]').classList.add('is-active-menu-parent');
    } else {
      button.setAttribute('aria-expanded', 'false');
      topLevelMenuItem.classList.remove('is-touch-event');
      topLevelMenuItem.querySelector('[data-drupal-selector="primary-nav-menu--level-2"]').classList.remove('is-active-menu-parent');
      topLevelMenuItem.querySelector('[data-drupal-selector="primary-nav-menu-🥕"]').classList.remove('is-active-menu-parent');
    }
  }

  Drupal.olivero.toggleSubNav = toggleSubNav;

  function handleBlur(e) {
    if (!Drupal.olivero.isDesktopNav()) return;
    setTimeout(function () {
      var menuParentItem = e.target.closest('[data-drupal-selector="primary-nav-menu-item-has-children"]');

      if (!menuParentItem.contains(document.activeElement)) {
        toggleSubNav(menuParentItem, false);
      }
    }, 200);
  }

  secondLevelNavMenus.forEach(function (el) {
    var button = el.querySelector('[data-drupal-selector="primary-nav-submenu-toggle-button"]');
    button.removeAttribute('aria-hidden');
    button.removeAttribute('tabindex');
    el.addEventListener('touchstart', function () {
      el.classList.add('is-touch-event');
    }, {
      passive: true
    });
    el.addEventListener('mouseover', function () {
      if (isDesktopNav() && !el.classList.contains('is-touch-event')) {
        el.classList.add('is-active-mouseover-event');
        toggleSubNav(el, true);
        setTimeout(function () {
          el.classList.remove('is-active-mouseover-event');
        }, 500);
      }
    });
    button.addEventListener('click', function () {
      if (!el.classList.contains('is-active-mouseover-event')) {
        toggleSubNav(el);
      }
    });
    el.addEventListener('mouseout', function () {
      if (isDesktopNav() && !document.activeElement.matches('[aria-expanded="true"], .is-active-menu-parent *')) {
        toggleSubNav(el, false);
      }
    });
    el.addEventListener('blur', handleBlur, true);
  });

  function closeAllSubNav() {
    secondLevelNavMenus.forEach(function (el) {
      if (el.contains(document.activeElement)) {
        el.querySelector('[data-drupal-selector="primary-nav-submenu-toggle-button"]').focus();
      }

      toggleSubNav(el, false);
    });
  }

  Drupal.olivero.closeAllSubNav = closeAllSubNav;

  function areAnySubNavsOpen() {
    var subNavsAreOpen = false;
    secondLevelNavMenus.forEach(function (el) {
      var button = el.querySelector('[data-drupal-selector="primary-nav-submenu-toggle-button"]');
      var state = button.getAttribute('aria-expanded') === 'true';

      if (state) {
        subNavsAreOpen = true;
      }
    });
    return subNavsAreOpen;
  }

  Drupal.olivero.areAnySubNavsOpen = areAnySubNavsOpen;
  document.addEventListener('keyup', function (e) {
    if (e.key === 'Escape' || e.key === 'Esc') {
      if (isDesktopNav()) closeAllSubNav();
    }
  });
  document.addEventListener('touchstart', function (e) {
    if (areAnySubNavsOpen() && !e.target.matches('[data-drupal-selector="header-nav"], [data-drupal-selector="header-nav"] *')) {
      closeAllSubNav();
    }
  }, {
    passive: true
  });
})(Drupal);;
/**
* DO NOT EDIT THIS FILE.
* See the following change record for more information,
* https://www.drupal.org/node/2815083
* @preserve
**/

(function (Drupal, once) {
  function transitionToDesktopNavigation(navWrapper, navItem) {
    document.body.classList.remove('is-always-mobile-nav');

    if (navWrapper.clientHeight > navItem.clientHeight) {
      document.body.classList.add('is-always-mobile-nav');
    }
  }

  function checkIfDesktopNavigationWraps(entries) {
    var navItem = document.querySelector('.primary-nav__menu-item');

    if (Drupal.olivero.isDesktopNav() && entries[0].contentRect.height > navItem.clientHeight) {
      var navMediaQuery = window.matchMedia("(max-width: ".concat(window.innerWidth + 5, "px)"));
      document.body.classList.add('is-always-mobile-nav');
      navMediaQuery.addEventListener('change', function () {
        transitionToDesktopNavigation(entries[0].target, navItem);
      }, {
        once: true
      });
    }
  }

  function init(primaryNav) {
    if ('ResizeObserver' in window) {
      var resizeObserver = new ResizeObserver(checkIfDesktopNavigationWraps);
      resizeObserver.observe(primaryNav);
    }
  }

  Drupal.behaviors.automaticMobileNav = {
    attach: function attach(context) {
      once('olivero-automatic-mobile-nav', '[data-drupal-selector="primary-nav-menu--level-1"]', context).forEach(init);
    }
  };
})(Drupal, once);;
