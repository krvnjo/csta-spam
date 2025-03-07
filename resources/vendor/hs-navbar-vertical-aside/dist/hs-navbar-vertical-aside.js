(function webpackUniversalModuleDefinition(root, factory) {
  if (typeof exports === "object" && typeof module === "object") module.exports = factory();
  else if (typeof define === "function" && define.amd) define([], factory);
  else if (typeof exports === "object") exports["HSSideNav"] = factory();
  else root["HSSideNav"] = factory();
})(window, function () {
  return /******/ (function (modules) {
    // webpackBootstrap
    /******/ // The module cache
    /******/ var installedModules = {};
    /******/
    /******/ // The require function
    /******/ function __webpack_require__(moduleId) {
      /******/
      /******/ // Check if module is in cache
      /******/ if (installedModules[moduleId]) {
        /******/ return installedModules[moduleId].exports;
        /******/
      }
      /******/ // Create a new module (and put it into the cache)
      /******/ var module = (installedModules[moduleId] = {
        /******/ i: moduleId,
        /******/ l: false,
        /******/ exports: {},
        /******/
      });
      /******/
      /******/ // Execute the module function
      /******/ modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
      /******/
      /******/ // Flag the module as loaded
      /******/ module.l = true;
      /******/
      /******/ // Return the exports of the module
      /******/ return module.exports;
      /******/
    }
    /******/
    /******/
    /******/ // expose the modules object (__webpack_modules__)
    /******/ __webpack_require__.m = modules;
    /******/
    /******/ // expose the module cache
    /******/ __webpack_require__.c = installedModules;
    /******/
    /******/ // define getter function for harmony exports
    /******/ __webpack_require__.d = function (exports, name, getter) {
      /******/ if (!__webpack_require__.o(exports, name)) {
        /******/ Object.defineProperty(exports, name, { enumerable: true, get: getter });
        /******/
      }
      /******/
    };
    /******/
    /******/ // define __esModule on exports
    /******/ __webpack_require__.r = function (exports) {
      /******/ if (typeof Symbol !== "undefined" && Symbol.toStringTag) {
        /******/ Object.defineProperty(exports, Symbol.toStringTag, { value: "Module" });
        /******/
      }
      /******/ Object.defineProperty(exports, "__esModule", { value: true });
      /******/
    };
    /******/
    /******/ // create a fake namespace object
    /******/ // mode & 1: value is a module id, require it
    /******/ // mode & 2: merge all properties of value into the ns
    /******/ // mode & 4: return value when already ns object
    /******/ // mode & 8|1: behave like require
    /******/ __webpack_require__.t = function (value, mode) {
      /******/ if (mode & 1) value = __webpack_require__(value);
      /******/ if (mode & 8) return value;
      /******/ if (mode & 4 && typeof value === "object" && value && value.__esModule) return value;
      /******/ var ns = Object.create(null);
      /******/ __webpack_require__.r(ns);
      /******/ Object.defineProperty(ns, "default", { enumerable: true, value: value });
      /******/ if (mode & 2 && typeof value != "string")
        for (var key in value)
          __webpack_require__.d(
            ns,
            key,
            function (key) {
              return value[key];
            }.bind(null, key),
          );
      /******/ return ns;
      /******/
    };
    /******/
    /******/ // getDefaultExport function for compatibility with non-harmony modules
    /******/ __webpack_require__.n = function (module) {
      /******/ var getter =
        module && module.__esModule
          ? /******/ function getDefault() {
              return module["default"];
            }
          : /******/ function getModuleExports() {
              return module;
            };
      /******/ __webpack_require__.d(getter, "a", getter);
      /******/ return getter;
      /******/
    };
    /******/
    /******/ // Object.prototype.hasOwnProperty.call
    /******/ __webpack_require__.o = function (object, property) {
      return Object.prototype.hasOwnProperty.call(object, property);
    };
    /******/
    /******/ // __webpack_public_path__
    /******/ __webpack_require__.p = "";
    /******/
    /******/
    /******/ // Load entry module and return exports
    /******/ return __webpack_require__((__webpack_require__.s = "./src/hs-navbar-vertical-aside.js"));
    /******/
  })(
    /************************************************************************/
    /******/ {
      /***/ "./src/hs-navbar-vertical-aside.js":
        /*!*****************************************!*\
  !*** ./src/hs-navbar-vertical-aside.js ***!
  \*****************************************/
        /*! exports provided: default */
        /***/ function (module, __webpack_exports__, __webpack_require__) {
          "use strict";
          eval(
            "__webpack_require__.r(__webpack_exports__);\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"default\", function() { return HSSideNav; });\n/* harmony import */ var _utils_slideUp__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./utils/slideUp */ \"./src/utils/slideUp.js\");\n/* harmony import */ var _utils_slideDown__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./utils/slideDown */ \"./src/utils/slideDown.js\");\n/* harmony import */ var _utils_getParents__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./utils/getParents */ \"./src/utils/getParents.js\");\nfunction _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread(); }\n\nfunction _nonIterableSpread() { throw new TypeError(\"Invalid attempt to spread non-iterable instance.\\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.\"); }\n\nfunction _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === \"string\") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === \"Object\" && o.constructor) n = o.constructor.name; if (n === \"Map\" || n === \"Set\") return Array.from(o); if (n === \"Arguments\" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }\n\nfunction _iterableToArray(iter) { if (typeof Symbol !== \"undefined\" && Symbol.iterator in Object(iter)) return Array.from(iter); }\n\nfunction _arrayWithoutHoles(arr) { if (Array.isArray(arr)) return _arrayLikeToArray(arr); }\n\nfunction _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }\n\nfunction _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError(\"Cannot call a class as a function\"); } }\n\nfunction _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if (\"value\" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }\n\nfunction _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }\n\n\n\n\n\nvar HSSideNav = /*#__PURE__*/function () {\n  function HSSideNav(el, settings) {\n    _classCallCheck(this, HSSideNav);\n\n    this.$el = typeof el === \"string\" ? document.querySelector(el) : el;\n    if (!this.$el) return;\n    this.defaults = {\n      defaultWidth: 0,\n      mainContainer: 'body',\n      autoscrollToActive: true,\n      compactClass: '.navbar-vertical-aside-compact-mode',\n      compactMinClass: '.navbar-vertical-aside-compact-mini-mode',\n      minClass: '.navbar-vertical-aside-mini-mode',\n      closedClass: '.navbar-vertical-aside-closed-mode',\n      navbarVertical: '.navbar-vertical-content',\n      transitionOnClassName: 'navbar-vertical-aside-transition-on',\n      mobileOverlayClass: '.navbar-vertical-aside-mobile-overlay',\n      toggleInvokerClass: '.js-navbar-vertical-aside-toggle-invoker',\n      subMenuClass: '.js-navbar-vertical-aside-submenu',\n      subMenuInvokerClass: '.js-navbar-vertical-aside-menu-link',\n      subMenuInvokerActiveClass: '.show',\n      hasSubMenuClass: '.navbar-vertical-aside-has-menu',\n      subMenuAnimationSpeed: 200,\n      subMenuOpenEvent: 'hover',\n      showClassNames: {\n        xs: 'navbar-vertical-aside-show-xs',\n        sm: 'navbar-vertical-aside-show-sm',\n        md: 'navbar-vertical-aside-show-md',\n        lg: 'navbar-vertical-aside-show-lg',\n        xl: 'navbar-vertical-aside-show-xl'\n      },\n      $showedMenu: null,\n      onMini: function onMini() {},\n      onFull: function onFull() {},\n      onInitialized: function onInitialized() {}\n    };\n    this.dataSettings = this.$el.hasAttribute('data-hs-navbar-vertical-aside') ? JSON.parse(this.$el.getAttribute('data-hs-navbar-vertical-aside')) : {};\n    this.settings = Object.assign({}, this.defaults, this.dataSettings, settings);\n    this.openedMenus = [];\n    this.items = this.$el.querySelectorAll(this.settings.hasSubMenuClass); // this.topLevels = document.querySelector(this.settings.hasSubMenuClass).parentNode.closest(':not(' + this.settings.subMenuClass + ')').querySelectorAll(`:scope > ${this.settings.hasSubMenuClass}`)\n\n    this.$container = document.querySelector(this.settings.mainContainer);\n    this.isMini = this.$container.classList.contains(this.settings.minClass.slice(1));\n    this.isCompact = this.$container.classList.contains(this.settings.compactClass.slice(1));\n    this.initializedClass = '.navbar-vertical-aside-initialized';\n  }\n\n  _createClass(HSSideNav, [{\n    key: \"init\",\n    value: function init() {\n      var _this = this;\n\n      if (!this.$el) return;\n      this.setState();\n\n      if (this.settings.autoscrollToActive) {\n        var $active = this.$el.querySelector('.active');\n\n        if ($active) {\n          if ($active.getBoundingClientRect().y > document.querySelector(this.settings.navbarVertical).getBoundingClientRect().height) {\n            setTimeout(function () {\n              $active.scrollIntoView({\n                behavior: 'smooth'\n              });\n            }, 100);\n          }\n        }\n      } // Click events\n\n\n      document.addEventListener('click', function (e) {\n        // Toggle aside menu\n        if (e.target.closest(_this.settings.toggleInvokerClass)) {\n          _this.toggleSidebar();\n        }\n      }); // Rebuild states for aside menu on resizing\n\n      window.addEventListener('resize', function () {\n        if (window.innerWidth !== _this.defaultWidth) {\n          _this.setState();\n        }\n      });\n      var collapseElementList = [].slice.call(document.querySelectorAll('.nav-collapse'));\n      this.collapseList = collapseElementList.map(function (collapseEl) {\n        return new bootstrap.Collapse(collapseEl, {\n          toggle: false\n        });\n      });\n      var $mainContainer = document.querySelector(this.settings.mainContainer);\n      this.topLevelElements = collapseElementList.filter(function (collapseEl) {\n        return Object(_utils_getParents__WEBPACK_IMPORTED_MODULE_2__[\"default\"])(collapseEl, '.nav-collapse').length === 1;\n      }); // Toggle sub menus on hover\n\n      var timeOut = null;\n\n      if (this.settings.subMenuOpenEvent === 'hover') {\n        this.collapseList.forEach(function (collapse) {\n          Array.from([collapse._element, collapse._element.previousElementSibling]).forEach(function ($el) {\n            $el.addEventListener('mouseenter', function (e) {\n              if (!$mainContainer.classList.contains(_this.settings.minClass.slice(1)) && !_this.isCompact) return;\n              clearTimeout(timeOut);\n\n              if (_this.topLevelElements.includes(collapse._element)) {\n                collapse.show();\n              }\n            });\n            $el.addEventListener('mouseleave', function (e) {\n              if (!$mainContainer.classList.contains(_this.settings.minClass.slice(1)) && !_this.isCompact) return;\n\n              if (_this.topLevelElements.includes($el.parentElement.querySelector('.nav-collapse'))) {\n                timeOut = setTimeout(function () {\n                  collapse.hide();\n                }, 200);\n              }\n            });\n          });\n        });\n      }\n\n      function prepareParentsTargetID($menu) {\n        var id = $menu.getAttribute('id');\n        $menu.querySelectorAll('.nav-collapse').forEach(function ($subMenu) {\n          if (id && !$subMenu.hasAttribute('hs-parent-area')) {\n            $subMenu.setAttribute('hs-parent-area', \"#\".concat(id));\n            prepareParentsTargetID($subMenu);\n          }\n        });\n      }\n\n      prepareParentsTargetID(document.querySelector('#navbarVerticalMenu'));\n      this.collapseList.forEach(function (collapse) {\n        collapse._element.addEventListener('show.bs.collapse', function (e) {\n          var trigeredEl = e.target,\n              parentEl = e.target.hasAttribute('hs-parent-area') ? document.querySelector(e.target.getAttribute('hs-parent-area')) : null;\n          trigeredEl.previousElementSibling.setAttribute('aria-expanded', true); // Remove animation on mobile\n\n          if (($mainContainer.classList.contains(_this.settings.minClass.slice(1)) || _this.isCompact) && _this.topLevelElements.includes(trigeredEl)) {\n            e.preventDefault();\n\n            _this.setPosition(trigeredEl, trigeredEl.previousElementSibling);\n\n            trigeredEl.style.height = 'auto';\n            trigeredEl.classList.add('show');\n          } // Check if menu is outside of the screen\n\n\n          setTimeout(function () {\n            if (($mainContainer.classList.contains(_this.settings.minClass.slice(1)) || _this.isCompact) && parentEl && parentEl.offsetHeight + parentEl.offsetTop > window.innerHeight) {\n              var distance = parentEl.offsetHeight + parentEl.offsetTop - window.innerHeight;\n              parentEl.style.top = parentEl.offsetTop - distance + 'px';\n              parentEl.style.transition = '.4s';\n              setTimeout(function () {\n                parentEl.style.transition = 'unset';\n              }, 400);\n            }\n          }, 500); // Close others submenu\n\n          _this.collapseList.forEach(function (collapse) {\n            var collapseEl = collapse._element;\n            if (collapseEl === trigeredEl) return;\n            var triggeredArea = trigeredEl.getAttribute('hs-parent-area'),\n                collapseArea = collapseEl.getAttribute('hs-parent-area');\n\n            if (collapseEl && triggeredArea ? collapseArea === triggeredArea : false) {\n              collapse.hide();\n              collapseEl.classList.remove('nav-collapse-action-mobile');\n              collapseEl.previousElementSibling.setAttribute('aria-expanded', false);\n            }\n          });\n        });\n\n        collapse._element.addEventListener('hide.bs.collapse', function (e) {\n          var trigeredEl = e.target;\n          trigeredEl.classList.remove('nav-collapse-action-mobile');\n          trigeredEl.previousElementSibling.setAttribute('aria-expanded', false); // Remove animation on mobile\n\n          if (($mainContainer.classList.contains(_this.settings.minClass.slice(1)) || _this.isCompact) && _this.topLevelElements.includes(trigeredEl)) {\n            trigeredEl.style.opacity = 0;\n            setTimeout(function () {\n              trigeredEl.style.opacity = 1;\n            }, 400);\n          } // Collapse all sub menus\n\n\n          trigeredEl.querySelectorAll('.nav-collapse').forEach(function ($menu) {\n            var collapse = _this.collapseList.find(function (collapse) {\n              return collapse._element === $menu;\n            });\n\n            if (collapse) collapse.hide(false);\n          });\n        });\n      }); // Add overlay for mobile\n\n      var $sideNavOverlay = document.createElement('div');\n      $sideNavOverlay.classList.add(this.settings.toggleInvokerClass.slice(1), this.settings.mobileOverlayClass.slice(1));\n      document.body.appendChild($sideNavOverlay); // Add transition state\n\n      this.$el.addEventListener('transitionend', function () {\n        document.querySelector(_this.settings.mainContainer).classList.remove(_this.settings.transitionOnClassName);\n      }); // Done initializing\n\n      this.$el.classList.add(this.initializedClass.slice(1));\n      document.querySelectorAll(this.settings.toggleInvokerClass).forEach(function (el) {\n        return el.style.opacity = 1;\n      });\n      setTimeout(function () {\n        _this.settings.onInitialized();\n      });\n    }\n  }, {\n    key: \"toggleOnHover\",\n    value: function toggleOnHover(e, menu) {\n      var collapse = this.collapseList.find(function (collapse) {\n        return collapse._element.previousElementSibling === e.target && collapse._element === menu;\n      });\n\n      if (collapse) {\n        collapse.toggle();\n      }\n    }\n  }, {\n    key: \"setState\",\n    value: function setState() {\n      this.defaultWidth = window.innerWidth;\n      var isClosed = this.showResolutionChecking(),\n          mini = this.isMini || this.isCompact ? true : false;\n\n      if (isClosed) {\n        this.sidebarToggleClass = this.settings.closedClass;\n        this.$container.classList.add(this.settings.closedClass.slice(1));\n\n        if (!mini) {\n          this.$container.classList.remove(this.settings.minClass.slice(1));\n        }\n      } else {\n        this.sidebarToggleClass = this.settings.minClass;\n        this.$container.classList.remove(this.settings.closedClass.slice(1));\n      } // If mini mode, add save active item and remove show class to hide it\n\n\n      if (mini) {\n        this.settings.$showedMenu = document.querySelector('.nav-collapse.show');\n\n        if (this.settings.$showedMenu) {\n          this.settings.$showedMenu.classList.remove('show');\n        }\n      }\n    }\n  }, {\n    key: \"showResolutionChecking\",\n    value: function showResolutionChecking() {\n      if (this.$container.classList.contains(this.settings.showClassNames.xs) && window.innerWidth <= 0) {\n        return true;\n      } else if (this.$container.classList.contains(this.settings.showClassNames.sm) && window.innerWidth <= 576) {\n        return true;\n      } else if (this.$container.classList.contains(this.settings.showClassNames.md) && window.innerWidth <= 768) {\n        return true;\n      } else if (this.$container.classList.contains(this.settings.showClassNames.lg) && window.innerWidth <= 992) {\n        return true;\n      } else if (this.$container.classList.contains(this.settings.showClassNames.xl) && window.innerWidth <= 1200) {\n        return true;\n      } else {\n        return false;\n      }\n    }\n  }, {\n    key: \"toggleSubMenu\",\n    value: function toggleSubMenu($invoker) {\n      var _this2 = this;\n\n      if (!$invoker) return null; // Prepare variables\n\n      var collapseOthers = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : true,\n          $menu = $invoker.querySelector(this.settings.subMenuClass),\n          $mainContainer = document.querySelector(this.settings.mainContainer),\n          allExcludeTarget = _toConsumableArray($invoker.parentNode.querySelectorAll(\":scope > \".concat(this.settings.hasSubMenuClass))).filter(function ($item) {\n        return $item !== $invoker;\n      }),\n          onAction = $mainContainer.classList.contains(this.settings.transitionOnClassName),\n          topLevel = !$invoker.parentNode.classList.contains(this.settings.subMenuClass.slice(1)),\n          mini = $mainContainer.classList.contains(this.settings.minClass.slice(1)) || $mainContainer.classList.contains(this.settings.compactMinClass.slice(1)) ? true : false,\n          parentMenu = $invoker; // Close excluded targets\n\n\n      if (collapseOthers && onAction || collapseOthers && topLevel && mini) {\n        allExcludeTarget.reduce(function (acc, $item) {\n          return acc = [].concat(_toConsumableArray(acc), _toConsumableArray($item.querySelectorAll(_this2.settings.subMenuClass)));\n        }, []).forEach(function ($item) {\n          $item.style.display = 'none';\n          $item.parentNode.classList.remove(_this2.settings.subMenuInvokerActiveClass.slice(1));\n        });\n      } else if (collapseOthers) {\n        allExcludeTarget.reduce(function (acc, $item) {\n          return acc = [].concat(_toConsumableArray(acc), _toConsumableArray($item.querySelectorAll(_this2.settings.subMenuClass)));\n        }, []).forEach(function ($item) {\n          Object(_utils_slideUp__WEBPACK_IMPORTED_MODULE_0__[\"default\"])($item, _this2.settings.subMenuAnimationSpeed).parentNode.classList.remove(_this2.settings.subMenuInvokerActiveClass.slice(1));\n        });\n      } // Close sub menu immediately\n\n\n      if (onAction || topLevel && mini) {\n        $menu.style.transition = 'unset';\n\n        if (window.getComputedStyle($menu).display === 'none') {\n          $menu.style.display = 'block';\n        } else {\n          $menu.style.display = 'none';\n        }\n      } // Close sub menu with animation\n      else {\n          while (parentMenu.parentNode.classList.contains(this.settings.subMenuClass.slice(1))) {\n            parentMenu = parentMenu.parentNode;\n          }\n\n          if (window.getComputedStyle($menu).display === 'none') {\n            Object(_utils_slideDown__WEBPACK_IMPORTED_MODULE_1__[\"default\"])($menu, this.settings.subMenuAnimationSpeed);\n          } else {\n            Object(_utils_slideUp__WEBPACK_IMPORTED_MODULE_0__[\"default\"])($menu, this.settings.subMenuAnimationSpeed);\n          }\n\n          if (mini) {\n            setTimeout(function () {\n              if (parentMenu.offsetHeight + parentMenu.offsetTop > window.innerHeight) {\n                var distance = parentMenu.offsetHeight + parentMenu.offsetTop - window.innerHeight;\n                parentMenu.style.top = parentMenu.offsetTop - distance + 'px';\n                parentMenu.style.transition = '.4s';\n              }\n            }, this.settings.subMenuAnimationSpeed);\n          }\n        } // Toggle Class\n\n\n      $invoker.classList.contains(this.settings.subMenuInvokerActiveClass.slice(1)) ? $invoker.classList.remove(this.settings.subMenuInvokerActiveClass.slice(1)) : $invoker.classList.add(this.settings.subMenuInvokerActiveClass.slice(1)); // Smart position\n\n      if ($menu.offsetParent) {\n        this.setPosition($menu, $invoker);\n        document.querySelector('.navbar-vertical-container').addEventListener('scroll', function () {\n          _this2.setPosition($menu, $invoker);\n        }, 1000);\n      }\n\n      return $invoker;\n    }\n  }, {\n    key: \"toggleSidebar\",\n    value: function toggleSidebar() {\n       // Get opened menus\n\n      var notHidden = function notHidden(els) {\n        return _toConsumableArray(els).filter(function ($el) {\n          return window.getComputedStyle($el).display !== 'none';\n        });\n      };\n\n      var $mainContainer = document.querySelector(this.settings.mainContainer);\n      $mainContainer.classList.add(this.settings.transitionOnClassName); // Toggle class\n\n      $mainContainer.classList.contains(this.sidebarToggleClass.slice(1)) ? $mainContainer.classList.remove(this.sidebarToggleClass.slice(1)) : $mainContainer.classList.add(this.sidebarToggleClass.slice(1)); // Toggle aside\n\n      if ($mainContainer.classList.contains(this.sidebarToggleClass.slice(1))) {\n        $mainContainer.classList.add(this.settings.minClass.slice(1));\n      } else {\n        $mainContainer.classList.remove(this.settings.minClass.slice(1));\n      } // Additional for plugin\n\n\n      if (!this.showResolutionChecking() && $mainContainer.classList.contains(this.settings.minClass.slice(1)) || this.showResolutionChecking() && $mainContainer.classList.contains(this.settings.closedClass.slice(1))) {\n        this.settings.onMini();\n        window.localStorage.setItem('hs-navbar-vertical-aside-mini', false);\n      } else {\n        this.settings.onFull();\n        window.localStorage.removeItem('hs-navbar-vertical-aside-mini');\n      } // Close/Open sub menus\n\n\n      if ($mainContainer.classList.contains(this.settings.minClass.slice(1)) || this.isCompact) {\n        var $menu = document.querySelector('.nav-collapse.show');\n        if (!$menu) return;\n        $menu.classList.remove('show');\n        $menu.classList.add('nav-collapse-action-mobile');\n        var collapse = this.collapseList.find(function (collapse) {\n          return collapse._element === $menu;\n        });\n        collapse.hide();\n      } else {\n        // If the mini mod is enabled, when expand the sidebar, a menu will open with an active item\n        if (this.settings.$showedMenu) {\n          this.settings.$showedMenu.classList.add('show');\n          this.settings.$showedMenu = null;\n        }\n\n        document.querySelectorAll('.nav-collapse-action-mobile').forEach(function ($item) {\n          $item.classList.remove('nav-collapse-action-mobile');\n          $item.classList.add('show');\n          document.querySelectorAll('.nav-collapse.show').forEach(function ($menu) {\n            $menu.classList.add('show');\n          });\n        });\n        document.querySelectorAll('.nav-collapse').forEach(function ($item) {\n          $item.style.top = 0;\n        });\n      }\n    }\n  }, {\n    key: \"setPosition\",\n    value: function setPosition($menu, $invoker) {\n      $menu.classList.add('nav-collapse-action-mobile');\n      $menu.style.top = $invoker.getBoundingClientRect().top + 'px';\n      setTimeout(function () {\n        if ($menu.offsetHeight + $menu.offsetTop > window.innerHeight) {\n          var distance = $menu.offsetHeight + $menu.offsetTop - window.innerHeight;\n          $menu.style.top = $invoker.offsetTop - distance + 'px';\n        }\n      });\n    }\n  }]);\n\n  return HSSideNav;\n}();\n\n\n\n//# sourceURL=webpack://HSSideNav/./src/hs-navbar-vertical-aside.js?",
          );

          /***/
        },

      /***/ "./src/utils/getParents.js":
        /*!*********************************!*\
  !*** ./src/utils/getParents.js ***!
  \*********************************/
        /*! exports provided: default */
        /***/ function (module, __webpack_exports__, __webpack_require__) {
          "use strict";
          eval(
            '__webpack_require__.r(__webpack_exports__);\n/* harmony default export */ __webpack_exports__["default"] = (function (elem, selector) {\n  // Element.matches() polyfill\n  if (!Element.prototype.matches) {\n    Element.prototype.matches = Element.prototype.matchesSelector || Element.prototype.mozMatchesSelector || Element.prototype.msMatchesSelector || Element.prototype.oMatchesSelector || Element.prototype.webkitMatchesSelector || function (s) {\n      var matches = (this.document || this.ownerDocument).querySelectorAll(s),\n          i = matches.length;\n\n      while (--i >= 0 && matches.item(i) !== this) {}\n\n      return i > -1;\n    };\n  } // Set up a parent array\n\n\n  var parents = []; // Push each parent element to the array\n\n  for (; elem && elem !== document; elem = elem.parentNode) {\n    if (selector) {\n      if (elem.matches(selector)) {\n        parents.push(elem);\n      }\n\n      continue;\n    }\n\n    parents.push(elem);\n  } // Return our parent array\n\n\n  return parents;\n});\n\n//# sourceURL=webpack://HSSideNav/./src/utils/getParents.js?',
          );

          /***/
        },

      /***/ "./src/utils/slideDown.js":
        /*!********************************!*\
  !*** ./src/utils/slideDown.js ***!
  \********************************/
        /*! exports provided: default */
        /***/ function (module, __webpack_exports__, __webpack_require__) {
          "use strict";
          eval(
            "__webpack_require__.r(__webpack_exports__);\nvar slideDown = function slideDown(target) {\n  var duration = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 500;\n  target.style.removeProperty('display');\n  var display = window.getComputedStyle(target).display;\n  if (display === 'none') display = 'block';\n  target.style.display = display;\n  var height = target.offsetHeight;\n  target.style.overflow = 'hidden';\n  target.style.height = 0;\n  target.style.paddingTop = 0;\n  target.style.paddingBottom = 0;\n  target.style.marginTop = 0;\n  target.style.marginBottom = 0;\n  target.offsetHeight;\n  target.style.boxSizing = 'border-box';\n  target.style.transitionProperty = \"height, margin, padding\";\n  target.style.transitionDuration = duration + 'ms';\n  target.style.height = height + 'px';\n  target.style.removeProperty('padding-top');\n  target.style.removeProperty('padding-bottom');\n  target.style.removeProperty('margin-top');\n  target.style.removeProperty('margin-bottom');\n  window.setTimeout(function () {\n    target.style.removeProperty('height');\n    target.style.removeProperty('overflow');\n    target.style.removeProperty('transition-duration');\n    target.style.removeProperty('transition-property');\n  }, duration);\n};\n\n/* harmony default export */ __webpack_exports__[\"default\"] = (slideDown);\n\n//# sourceURL=webpack://HSSideNav/./src/utils/slideDown.js?",
          );

          /***/
        },

      /***/ "./src/utils/slideUp.js":
        /*!******************************!*\
  !*** ./src/utils/slideUp.js ***!
  \******************************/
        /*! exports provided: default */
        /***/ function (module, __webpack_exports__, __webpack_require__) {
          "use strict";
          eval(
            "__webpack_require__.r(__webpack_exports__);\nvar slideUp = function slideUp(target) {\n  var duration = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 500;\n  target.style.transitionProperty = 'height, margin, padding';\n  target.style.transitionDuration = duration + 'ms';\n  target.style.boxSizing = 'border-box';\n  target.style.height = target.offsetHeight + 'px';\n  target.offsetHeight;\n  target.style.overflow = 'hidden';\n  target.style.height = 0;\n  target.style.paddingTop = 0;\n  target.style.paddingBottom = 0;\n  target.style.marginTop = 0;\n  target.style.marginBottom = 0;\n  window.setTimeout(function () {\n    target.style.display = 'none';\n    target.style.removeProperty('height');\n    target.style.removeProperty('padding-top');\n    target.style.removeProperty('padding-bottom');\n    target.style.removeProperty('margin-top');\n    target.style.removeProperty('margin-bottom');\n    target.style.removeProperty('overflow');\n    target.style.removeProperty('transition-duration');\n    target.style.removeProperty('transition-property'); //alert(\"!\");\n  }, duration);\n  return target;\n};\n\n/* harmony default export */ __webpack_exports__[\"default\"] = (slideUp);\n\n//# sourceURL=webpack://HSSideNav/./src/utils/slideUp.js?",
          );

          /***/
        },

      /******/
    },
  )["default"];
});
