"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["messages"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Messages.vue?vue&type=script&lang=js":
/*!*********************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Messages.vue?vue&type=script&lang=js ***!
  \*********************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _components_CardImageCategory__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../components/CardImageCategory */ "./resources/js/components/CardImageCategory.vue");
function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }
function _regeneratorRuntime() { "use strict"; /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/facebook/regenerator/blob/main/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return exports; }; var exports = {}, Op = Object.prototype, hasOwn = Op.hasOwnProperty, defineProperty = Object.defineProperty || function (obj, key, desc) { obj[key] = desc.value; }, $Symbol = "function" == typeof Symbol ? Symbol : {}, iteratorSymbol = $Symbol.iterator || "@@iterator", asyncIteratorSymbol = $Symbol.asyncIterator || "@@asyncIterator", toStringTagSymbol = $Symbol.toStringTag || "@@toStringTag"; function define(obj, key, value) { return Object.defineProperty(obj, key, { value: value, enumerable: !0, configurable: !0, writable: !0 }), obj[key]; } try { define({}, ""); } catch (err) { define = function define(obj, key, value) { return obj[key] = value; }; } function wrap(innerFn, outerFn, self, tryLocsList) { var protoGenerator = outerFn && outerFn.prototype instanceof Generator ? outerFn : Generator, generator = Object.create(protoGenerator.prototype), context = new Context(tryLocsList || []); return defineProperty(generator, "_invoke", { value: makeInvokeMethod(innerFn, self, context) }), generator; } function tryCatch(fn, obj, arg) { try { return { type: "normal", arg: fn.call(obj, arg) }; } catch (err) { return { type: "throw", arg: err }; } } exports.wrap = wrap; var ContinueSentinel = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var IteratorPrototype = {}; define(IteratorPrototype, iteratorSymbol, function () { return this; }); var getProto = Object.getPrototypeOf, NativeIteratorPrototype = getProto && getProto(getProto(values([]))); NativeIteratorPrototype && NativeIteratorPrototype !== Op && hasOwn.call(NativeIteratorPrototype, iteratorSymbol) && (IteratorPrototype = NativeIteratorPrototype); var Gp = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(IteratorPrototype); function defineIteratorMethods(prototype) { ["next", "throw", "return"].forEach(function (method) { define(prototype, method, function (arg) { return this._invoke(method, arg); }); }); } function AsyncIterator(generator, PromiseImpl) { function invoke(method, arg, resolve, reject) { var record = tryCatch(generator[method], generator, arg); if ("throw" !== record.type) { var result = record.arg, value = result.value; return value && "object" == _typeof(value) && hasOwn.call(value, "__await") ? PromiseImpl.resolve(value.__await).then(function (value) { invoke("next", value, resolve, reject); }, function (err) { invoke("throw", err, resolve, reject); }) : PromiseImpl.resolve(value).then(function (unwrapped) { result.value = unwrapped, resolve(result); }, function (error) { return invoke("throw", error, resolve, reject); }); } reject(record.arg); } var previousPromise; defineProperty(this, "_invoke", { value: function value(method, arg) { function callInvokeWithMethodAndArg() { return new PromiseImpl(function (resolve, reject) { invoke(method, arg, resolve, reject); }); } return previousPromise = previousPromise ? previousPromise.then(callInvokeWithMethodAndArg, callInvokeWithMethodAndArg) : callInvokeWithMethodAndArg(); } }); } function makeInvokeMethod(innerFn, self, context) { var state = "suspendedStart"; return function (method, arg) { if ("executing" === state) throw new Error("Generator is already running"); if ("completed" === state) { if ("throw" === method) throw arg; return doneResult(); } for (context.method = method, context.arg = arg;;) { var delegate = context.delegate; if (delegate) { var delegateResult = maybeInvokeDelegate(delegate, context); if (delegateResult) { if (delegateResult === ContinueSentinel) continue; return delegateResult; } } if ("next" === context.method) context.sent = context._sent = context.arg;else if ("throw" === context.method) { if ("suspendedStart" === state) throw state = "completed", context.arg; context.dispatchException(context.arg); } else "return" === context.method && context.abrupt("return", context.arg); state = "executing"; var record = tryCatch(innerFn, self, context); if ("normal" === record.type) { if (state = context.done ? "completed" : "suspendedYield", record.arg === ContinueSentinel) continue; return { value: record.arg, done: context.done }; } "throw" === record.type && (state = "completed", context.method = "throw", context.arg = record.arg); } }; } function maybeInvokeDelegate(delegate, context) { var methodName = context.method, method = delegate.iterator[methodName]; if (undefined === method) return context.delegate = null, "throw" === methodName && delegate.iterator["return"] && (context.method = "return", context.arg = undefined, maybeInvokeDelegate(delegate, context), "throw" === context.method) || "return" !== methodName && (context.method = "throw", context.arg = new TypeError("The iterator does not provide a '" + methodName + "' method")), ContinueSentinel; var record = tryCatch(method, delegate.iterator, context.arg); if ("throw" === record.type) return context.method = "throw", context.arg = record.arg, context.delegate = null, ContinueSentinel; var info = record.arg; return info ? info.done ? (context[delegate.resultName] = info.value, context.next = delegate.nextLoc, "return" !== context.method && (context.method = "next", context.arg = undefined), context.delegate = null, ContinueSentinel) : info : (context.method = "throw", context.arg = new TypeError("iterator result is not an object"), context.delegate = null, ContinueSentinel); } function pushTryEntry(locs) { var entry = { tryLoc: locs[0] }; 1 in locs && (entry.catchLoc = locs[1]), 2 in locs && (entry.finallyLoc = locs[2], entry.afterLoc = locs[3]), this.tryEntries.push(entry); } function resetTryEntry(entry) { var record = entry.completion || {}; record.type = "normal", delete record.arg, entry.completion = record; } function Context(tryLocsList) { this.tryEntries = [{ tryLoc: "root" }], tryLocsList.forEach(pushTryEntry, this), this.reset(!0); } function values(iterable) { if (iterable) { var iteratorMethod = iterable[iteratorSymbol]; if (iteratorMethod) return iteratorMethod.call(iterable); if ("function" == typeof iterable.next) return iterable; if (!isNaN(iterable.length)) { var i = -1, next = function next() { for (; ++i < iterable.length;) if (hasOwn.call(iterable, i)) return next.value = iterable[i], next.done = !1, next; return next.value = undefined, next.done = !0, next; }; return next.next = next; } } return { next: doneResult }; } function doneResult() { return { value: undefined, done: !0 }; } return GeneratorFunction.prototype = GeneratorFunctionPrototype, defineProperty(Gp, "constructor", { value: GeneratorFunctionPrototype, configurable: !0 }), defineProperty(GeneratorFunctionPrototype, "constructor", { value: GeneratorFunction, configurable: !0 }), GeneratorFunction.displayName = define(GeneratorFunctionPrototype, toStringTagSymbol, "GeneratorFunction"), exports.isGeneratorFunction = function (genFun) { var ctor = "function" == typeof genFun && genFun.constructor; return !!ctor && (ctor === GeneratorFunction || "GeneratorFunction" === (ctor.displayName || ctor.name)); }, exports.mark = function (genFun) { return Object.setPrototypeOf ? Object.setPrototypeOf(genFun, GeneratorFunctionPrototype) : (genFun.__proto__ = GeneratorFunctionPrototype, define(genFun, toStringTagSymbol, "GeneratorFunction")), genFun.prototype = Object.create(Gp), genFun; }, exports.awrap = function (arg) { return { __await: arg }; }, defineIteratorMethods(AsyncIterator.prototype), define(AsyncIterator.prototype, asyncIteratorSymbol, function () { return this; }), exports.AsyncIterator = AsyncIterator, exports.async = function (innerFn, outerFn, self, tryLocsList, PromiseImpl) { void 0 === PromiseImpl && (PromiseImpl = Promise); var iter = new AsyncIterator(wrap(innerFn, outerFn, self, tryLocsList), PromiseImpl); return exports.isGeneratorFunction(outerFn) ? iter : iter.next().then(function (result) { return result.done ? result.value : iter.next(); }); }, defineIteratorMethods(Gp), define(Gp, toStringTagSymbol, "Generator"), define(Gp, iteratorSymbol, function () { return this; }), define(Gp, "toString", function () { return "[object Generator]"; }), exports.keys = function (val) { var object = Object(val), keys = []; for (var key in object) keys.push(key); return keys.reverse(), function next() { for (; keys.length;) { var key = keys.pop(); if (key in object) return next.value = key, next.done = !1, next; } return next.done = !0, next; }; }, exports.values = values, Context.prototype = { constructor: Context, reset: function reset(skipTempReset) { if (this.prev = 0, this.next = 0, this.sent = this._sent = undefined, this.done = !1, this.delegate = null, this.method = "next", this.arg = undefined, this.tryEntries.forEach(resetTryEntry), !skipTempReset) for (var name in this) "t" === name.charAt(0) && hasOwn.call(this, name) && !isNaN(+name.slice(1)) && (this[name] = undefined); }, stop: function stop() { this.done = !0; var rootRecord = this.tryEntries[0].completion; if ("throw" === rootRecord.type) throw rootRecord.arg; return this.rval; }, dispatchException: function dispatchException(exception) { if (this.done) throw exception; var context = this; function handle(loc, caught) { return record.type = "throw", record.arg = exception, context.next = loc, caught && (context.method = "next", context.arg = undefined), !!caught; } for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i], record = entry.completion; if ("root" === entry.tryLoc) return handle("end"); if (entry.tryLoc <= this.prev) { var hasCatch = hasOwn.call(entry, "catchLoc"), hasFinally = hasOwn.call(entry, "finallyLoc"); if (hasCatch && hasFinally) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } else if (hasCatch) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); } else { if (!hasFinally) throw new Error("try statement without catch or finally"); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } } } }, abrupt: function abrupt(type, arg) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc <= this.prev && hasOwn.call(entry, "finallyLoc") && this.prev < entry.finallyLoc) { var finallyEntry = entry; break; } } finallyEntry && ("break" === type || "continue" === type) && finallyEntry.tryLoc <= arg && arg <= finallyEntry.finallyLoc && (finallyEntry = null); var record = finallyEntry ? finallyEntry.completion : {}; return record.type = type, record.arg = arg, finallyEntry ? (this.method = "next", this.next = finallyEntry.finallyLoc, ContinueSentinel) : this.complete(record); }, complete: function complete(record, afterLoc) { if ("throw" === record.type) throw record.arg; return "break" === record.type || "continue" === record.type ? this.next = record.arg : "return" === record.type ? (this.rval = this.arg = record.arg, this.method = "return", this.next = "end") : "normal" === record.type && afterLoc && (this.next = afterLoc), ContinueSentinel; }, finish: function finish(finallyLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.finallyLoc === finallyLoc) return this.complete(entry.completion, entry.afterLoc), resetTryEntry(entry), ContinueSentinel; } }, "catch": function _catch(tryLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc === tryLoc) { var record = entry.completion; if ("throw" === record.type) { var thrown = record.arg; resetTryEntry(entry); } return thrown; } } throw new Error("illegal catch attempt"); }, delegateYield: function delegateYield(iterable, resultName, nextLoc) { return this.delegate = { iterator: values(iterable), resultName: resultName, nextLoc: nextLoc }, "next" === this.method && (this.arg = undefined), ContinueSentinel; } }, exports; }
function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }
function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: "Messages",
  components: {
    BktCardImageCategory: _components_CardImageCategory__WEBPACK_IMPORTED_MODULE_0__["default"]
  },
  data: function data() {
    return {
      info_categories: [{
        id: 1,
        code: 'platform',
        title: 'сообщения платформы',
        color: 'green'
      }, {
        id: 2,
        code: 'favourite',
        title: 'избранное',
        color: 'yellow'
      }, {
        id: 3,
        code: 'monitoring',
        title: 'мониторинг',
        color: 'red'
      }],
      selectedType: 'all',
      type_loading: false,
      signal: null,
      controller: null
    };
  },
  created: function created() {
    var page = 1;
    if (sessionStorage.getItem('messages_page')) {
      page = sessionStorage.getItem('messages_page');
    }
    this.getData(page);
  },
  computed: {
    items: function items() {
      return this.$store.getters.notifications;
    },
    pagination_data: function pagination_data() {
      return this.$store.getters.notifications_pagination;
    },
    loading: function loading() {
      return this.$store.getters.notifications_loading;
    },
    notifications_count: function notifications_count() {
      return this.$store.getters.notifications_count;
    }
  },
  methods: {
    getData: function getData() {
      var _arguments = arguments,
        _this = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee() {
        var page, type;
        return _regeneratorRuntime().wrap(function _callee$(_context) {
          while (1) switch (_context.prev = _context.next) {
            case 0:
              page = _arguments.length > 0 && _arguments[0] !== undefined ? _arguments[0] : 1;
              _this.controller = new AbortController();
              _this.signal = _this.controller.signal;
              type = _this.selectedType;
              if (sessionStorage.getItem('messages_page_type')) {
                type = sessionStorage.getItem('messages_page_type');
                if (type != _this.selectedType) {
                  _this.selectedType = type;
                }
              }
              sessionStorage.setItem('messages_page', page + '');
              _context.next = 8;
              return _this.$store.dispatch('getNotifications', {
                page: page,
                type: type,
                signal: _this.signal
              });
            case 8:
            case "end":
              return _context.stop();
          }
        }, _callee);
      }))();
    },
    setType: function setType(type) {
      var _this2 = this;
      // if (!this.loading) {
      if (this.signal) {
        this.controller.abort();
      }
      this.type_loading = true;
      this.selectedType = type;
      sessionStorage.setItem('messages_page_type', type);
      setTimeout(function () {
        _this2.getData(1).then(function (resp) {
          _this2.type_loading = false;
        })["catch"](function (resp) {
          _this2.type_loading = false;
        });
      }, 50);
      // }
    },
    changePage: function changePage(page) {
      var _this3 = this;
      if (this.signal) {
        this.controller.abort();
      }
      setTimeout(function () {
        _this3.getData(page).then(function () {
          var el = _this3.$refs.cardList;
          if (el) {
            requestAnimationFrame(function () {
              el.scrollIntoView({
                block: 'start',
                scrollBehavior: 'smooth'
              });
              requestAnimationFrame(function () {
                el.scrollIntoView();
              });
            });
          }
        });
      }, 50);
    },
    navigate: function navigate(message) {
      if (message.type === 'monitoring') {
        sessionStorage.setItem('monitoring_path_id', message.dataMonitoring.folderInfo.pathId);
        sessionStorage.setItem('monitoring' + message.dataMonitoring.folderInfo.pathId + '_page', '1');
        this.$router.push('/monitoring');
      }
      if (message.type === 'favourite') {
        this.$router.push('/lot/' + message.dataFavourite.id);
      }
      // this.$router.push(path);
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Messages.vue?vue&type=template&id=8c0212ba&scoped=true":
/*!********************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Messages.vue?vue&type=template&id=8c0212ba&scoped=true ***!
  \********************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* binding */ render),
/* harmony export */   staticRenderFns: () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function render() {
  var _vm = this,
    _c = _vm._self._c;
  return _c('div', {
    staticClass: "bkt-messages bkt-page bkt-container"
  }, [_c('h1', {
    staticClass: "bkt-page__title"
  }, [_vm._v("\n        Сообщения\n    ")]), _vm._v(" "), _c('div', {
    staticClass: "bkt-content"
  }, [_c('div', {
    ref: "cardList",
    staticClass: "row"
  }, [_c('div', {
    staticClass: "col-12 col-lg-3"
  }, [_c('div', {
    staticClass: "bkt-history__chats"
  }, [_c('ul', {
    staticClass: "list-unstyled text-left pt-4 pb-4"
  }, [_c('li', {
    staticClass: "bkt-chat",
    "class": {
      'bkt-bg-primary-lighter': _vm.selectedType == 'all'
    },
    attrs: {
      "id": "chat-1"
    },
    on: {
      "click": function click($event) {
        return _vm.setType('all');
      }
    }
  }, [_vm._v("\n                            Все\n                            "), _c('div', {
    staticClass: "bkt-chat__num rounded-pill bkt-bg-primary bkt-text-neutral-light"
  }, [_vm.notifications_count.all > 0 ? _c('span', {
    staticClass: "p-2"
  }, [_vm._v("\n                                    " + _vm._s(_vm.notifications_count.all) + "\n                                ")]) : _vm._e()])]), _vm._v(" "), _c('li', {
    staticClass: "bkt-chat",
    "class": {
      'bkt-bg-green-lighter': _vm.selectedType == 'platform'
    },
    attrs: {
      "id": "chat-2"
    },
    on: {
      "click": function click($event) {
        return _vm.setType('platform');
      }
    }
  }, [_c('div', {
    staticClass: "bkt-chat__text"
  }, [_c('bkt-icon', {
    attrs: {
      "name": 'Bell',
      "color": 'green',
      "width": "15px",
      "height": "15px"
    }
  }), _vm._v("\n                                Сообщения платформы\n                            ")], 1), _vm._v(" "), _c('div', {
    staticClass: "bkt-chat__num rounded-pill bkt-bg-green bkt-text-neutral-light"
  }, [_vm.notifications_count.platform > 0 ? _c('span', {
    staticClass: "p-2"
  }, [_vm._v("\n                                    " + _vm._s(_vm.notifications_count.platform) + "\n                                ")]) : _vm._e()])]), _vm._v(" "), _c('li', {
    staticClass: "bkt-chat",
    "class": {
      'bkt-bg-yellow-lighter': _vm.selectedType == 'favourite'
    },
    attrs: {
      "id": "chat-3"
    },
    on: {
      "click": function click($event) {
        return _vm.setType('favourite');
      }
    }
  }, [_c('div', {
    staticClass: "bkt-chat__text"
  }, [_c('bkt-icon', {
    attrs: {
      "name": 'Star',
      "color": 'yellow',
      "width": "15px",
      "height": "15px"
    }
  }), _vm._v("\n                                Избранное\n                            ")], 1), _vm._v(" "), _c('div', {
    staticClass: "bkt-chat__num rounded-pill bkt-bg-yellow bkt-text-neutral-light"
  }, [_vm.notifications_count.favourite > 0 ? _c('span', {
    staticClass: "p-2"
  }, [_vm._v("\n                                    " + _vm._s(_vm.notifications_count.favourite) + "\n                                ")]) : _vm._e()])]), _vm._v(" "), _c('li', {
    staticClass: "bkt-chat",
    "class": {
      'bkt-bg-red-lighter': _vm.selectedType == 'monitoring'
    },
    attrs: {
      "id": "chat-4"
    },
    on: {
      "click": function click($event) {
        return _vm.setType('monitoring');
      }
    }
  }, [_c('div', {
    staticClass: "bkt-chat__text"
  }, [_c('bkt-icon', {
    attrs: {
      "name": 'Target',
      "color": 'red',
      "width": "15px",
      "height": "15px"
    }
  }), _vm._v("\n                                Мониторинг\n                            ")], 1), _vm._v(" "), _c('div', {
    staticClass: "rounded-pill bkt-bg-red bkt-text-neutral-light"
  }, [_vm.notifications_count.monitoring > 0 ? _c('span', {
    staticClass: "p-2"
  }, [_vm._v("\n                                    " + _vm._s(_vm.notifications_count.monitoring) + "\n                                ")]) : _vm._e()])])])])]), _vm._v(" "), _c('div', {
    staticClass: "col-12 col-lg-9 bkt-gap-row-medium"
  }, [_c('div', {
    staticClass: "bkt-wrapper-column bkt-gap-row-medium"
  }, [_c('div', {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: !_vm.loading,
      expression: "!loading"
    }],
    staticClass: "bkt-wrapper-column bkt-gap-mini"
  }, _vm._l(_vm.items, function (message, index) {
    return message ? _c('div', {
      key: index,
      staticClass: "bkt-message",
      "class": {
        'bkt-cursor-pointer': message.type !== 'platform'
      },
      on: {
        "click": function click($event) {
          return _vm.navigate(message);
        }
      }
    }, [_c('bkt-icon', {
      staticClass: "bkt-message__check",
      attrs: {
        "name": 'Check',
        "color": message.isSeen ? 'primary' : 'main-lighter',
        "width": "15px",
        "height": "15px"
      }
    }), _vm._v(" "), _c('div', {
      staticClass: "d-md-none bkt-wrapper-between w-100"
    }, [_c('h6', {
      staticClass: "bkt-message__date"
    }, [_vm._v("\n                                    " + _vm._s(_vm._f("moment")(message.date, 'D MMMM YYYY')) + " в " + _vm._s(_vm._f("moment")(message.date, 'HH:mm')) + "\n                                ")]), _vm._v(" "), _c('div', {
      staticClass: "bkt-chat-content__info text-right"
    }, [_c('div', {
      staticClass: "bkt-message__type",
      "class": {
        'bkt-bg-red-lighter bkt-text-red': message.type == 'monitoring',
        'bkt-bg-yellow-lighter bkt-text-yellow': message.type == 'favourite',
        'bkt-bg-green-lighter bkt-text-green': message.type == 'platform'
      }
    }, [_vm._v("\n                                        " + _vm._s(message.type == 'monitoring' ? 'мониторинг' : '') + "\n                                        " + _vm._s(message.type == 'favourite' ? 'избранное' : '') + "\n                                        " + _vm._s(message.type == 'platform' ? 'сообщения платформы' : '') + "\n                                    ")])])]), _vm._v(" "), _c('div', {
      staticClass: "bkt-wrapper-column bkt-message__content"
    }, [_c('div', {
      staticClass: "bkt-wrapper bkt-nowrap me-auto ms-0"
    }, [message.type == 'favourite' ? _c('div', {
      staticClass: "bkt-message__image-wrapper"
    }, [(!message.dataFavourite.photos || message.dataFavourite.photos.length == 0) && message.dataFavourite.categories && message.dataFavourite.categories.length > 0 ? _c('bkt-card-image-category', {
      attrs: {
        "no_multiple": true,
        "categories": message.dataFavourite.categories
      }
    }) : _vm._e(), _vm._v(" "), message.dataFavourite.photos && message.dataFavourite.photos.length > 0 ? _c('img', {
      staticClass: "bkt-message__image",
      attrs: {
        "src": message.dataFavourite.photos[0].preview,
        "alt": ""
      }
    }) : _vm._e()], 1) : _vm._e(), _vm._v(" "), _c('div', {
      staticClass: "bkt-chat-content__text"
    }, [message.type == 'monitoring' && message.dataMonitoring ? _c('div', {
      staticClass: "bkt-badge mx-0 mb-2",
      "class": message.dataMonitoring.folderInfo.color ? 'bkt-bg-' + message.dataMonitoring.folderInfo.color : 'bkt-bg-primary'
    }, [_vm._v("\n                                            " + _vm._s(message.dataMonitoring.folderInfo.name) + "\n                                        ")]) : _vm._e(), _vm._v(" "), message.type == 'monitoring' ? _c('h5', {
      staticClass: "bkt-message__text bkt-cursor-pointer"
    }, [_vm._v("\n                                            Появились новые лоты в мониторинге:\n                                            " + _vm._s(message.dataMonitoring ? message.dataMonitoring.newLotCount : '0') + "\n                                        ")]) : _vm._e(), _vm._v(" "), message.type == 'platform' && message.dataPlatform ? _c('h6', {
      staticClass: "bkt-message__title"
    }, [_vm._v("\n                                            " + _vm._s(message.dataPlatform.label) + "\n                                        ")]) : _vm._e(), _vm._v(" "), message.type == 'platform' ? _c('h5', {
      staticClass: "bkt-message__text"
    }, [_vm._v("\n                                            " + _vm._s(message.dataPlatform ? message.dataPlatform.value : '') + "\n                                        ")]) : _vm._e(), _vm._v(" "), message.type == 'favourite' && message.dataFavourite ? _c('h6', {
      staticClass: "bkt-message__title bkt-card__title bkt-text-truncate bkt-arrow-after bkt-cursor-pointer"
    }, [_vm._v("\n                                            " + _vm._s(message.dataFavourite.description) + "\n                                        ")]) : _vm._e(), _vm._v(" "), message.type == 'favourite' ? _c('h5', {
      staticClass: "bkt-message__text"
    }, [_vm._v("\n                                            " + _vm._s(message.dataFavourite ? message.dataFavourite.detail : '') + "\n                                        ")]) : _vm._e()])]), _vm._v(" "), _c('h6', {
      staticClass: "d-none d-md-block bkt-message__date"
    }, [_vm._v("\n                                    " + _vm._s(_vm._f("moment")(message.date, 'D MMMM YYYY')) + " в " + _vm._s(_vm._f("moment")(message.date, 'HH:mm')) + "\n                                ")])]), _vm._v(" "), _c('div', {
      staticClass: "bkt-message__type d-none d-md-block",
      "class": {
        'bkt-bg-red-lighter bkt-text-red': message.type == 'monitoring',
        'bkt-bg-yellow-lighter bkt-text-yellow': message.type == 'favourite',
        'bkt-bg-green-lighter bkt-text-green': message.type == 'platform'
      }
    }, [_vm._v("\n                                " + _vm._s(message.type == 'monitoring' ? 'мониторинг' : '') + "\n                                " + _vm._s(message.type == 'favourite' ? 'избранное' : '') + "\n                                " + _vm._s(message.type == 'platform' ? 'сообщения платформы' : '') + "\n                            ")])], 1) : _vm._e();
  }), 0), _vm._v(" "), _c('div', {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: _vm.loading || _vm.type_loading,
      expression: "loading||type_loading"
    }],
    staticClass: "bkt-wrapper-column bkt-gap-mini"
  }, _vm._l(20, function (message, index) {
    return _c('div', {
      key: index,
      staticClass: "bkt-message"
    }, [_c('skeleton', {
      attrs: {
        "width": "15px",
        "height": "15px",
        "skeleton_class": "bkt-message__check"
      }
    }), _vm._v(" "), _c('div', {
      staticClass: "d-md-none bkt-wrapper-between w-100"
    }, [_c('skeleton', {
      attrs: {
        "skeleton_class": "bkt-message__date mb-1",
        "height": "12px"
      }
    }), _vm._v(" "), _c('div', {
      staticClass: "bkt-chat-content__info text-right"
    }, [_c('skeleton', {
      attrs: {
        "skeleton_class": "bkt-bkt-message__type",
        "width": "92px"
      }
    })], 1)], 1), _vm._v(" "), _c('div', {
      staticClass: "bkt-wrapper-column bkt-message__content"
    }, [_c('div', {
      staticClass: "bkt-wrapper bkt-nowrap me-auto ms-0"
    }, [_c('div', {
      staticClass: "bkt-message__image-wrapper"
    }, [_c('skeleton', {
      attrs: {
        "skeleton_class": "bkt-message__image"
      }
    })], 1), _vm._v(" "), _c('div', {
      staticClass: "bkt-chat-content__text"
    }, [_c('skeleton', {
      attrs: {
        "height": "14px",
        "width": "150px",
        "skeleton_class": "mb-1"
      }
    }), _vm._v(" "), _c('skeleton', {
      attrs: {
        "height": "12px",
        "width": "60%"
      }
    })], 1)]), _vm._v(" "), _c('skeleton', {
      attrs: {
        "height": "12px",
        "skeleton_class": "d-none d-md-block bkt-message__date"
      }
    })], 1), _vm._v(" "), _c('skeleton', {
      attrs: {
        "skeleton_class": "bkt-message__type d-none d-md-block",
        "width": "92px"
      }
    })], 1);
  }), 0), _vm._v(" "), _vm.pagination_data && !_vm.type_loading ? _c('bkt-pagination', {
    attrs: {
      "limit": 1,
      "data": _vm.pagination_data,
      "extraControls": false
    },
    on: {
      "change-page": _vm.changePage
    }
  }) : _vm._e()], 1)])])])]);
};
var staticRenderFns = [];


/***/ }),

/***/ "./resources/js/pages/Messages.vue":
/*!*****************************************!*\
  !*** ./resources/js/pages/Messages.vue ***!
  \*****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Messages_vue_vue_type_template_id_8c0212ba_scoped_true__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./Messages.vue?vue&type=template&id=8c0212ba&scoped=true */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Messages.vue?vue&type=template&id=8c0212ba&scoped=true");
/* harmony import */ var _Messages_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Messages.vue?vue&type=script&lang=js */ "./resources/js/pages/Messages.vue?vue&type=script&lang=js");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_1__["default"])(
  _Messages_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"],
  _Messages_vue_vue_type_template_id_8c0212ba_scoped_true__WEBPACK_IMPORTED_MODULE_2__.render,
  _Messages_vue_vue_type_template_id_8c0212ba_scoped_true__WEBPACK_IMPORTED_MODULE_2__.staticRenderFns,
  false,
  null,
  "8c0212ba",
  null
  
)

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/pages/Messages.vue?vue&type=script&lang=js":
/*!*****************************************************************!*\
  !*** ./resources/js/pages/Messages.vue?vue&type=script&lang=js ***!
  \*****************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Messages_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Messages.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Messages.vue?vue&type=script&lang=js");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Messages_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ })

}]);
//# sourceMappingURL=messages.js.map