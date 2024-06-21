"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["users-add"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/admin/users/AddUser.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/admin/users/AddUser.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var vue_the_mask__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vue-the-mask */ "./node_modules/vue-the-mask/dist/vue-the-mask.js");
/* harmony import */ var vue_the_mask__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(vue_the_mask__WEBPACK_IMPORTED_MODULE_1__);
function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); enumerableOnly && (symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; })), keys.push.apply(keys, symbols); } return keys; }
function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = null != arguments[i] ? arguments[i] : {}; i % 2 ? ownKeys(Object(source), !0).forEach(function (key) { _defineProperty(target, key, source[key]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } return target; }
function _defineProperty(obj, key, value) { key = _toPropertyKey(key); if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }
function _toPropertyKey(arg) { var key = _toPrimitive(arg, "string"); return _typeof(key) === "symbol" ? key : String(key); }
function _toPrimitive(input, hint) { if (_typeof(input) !== "object" || input === null) return input; var prim = input[Symbol.toPrimitive]; if (prim !== undefined) { var res = prim.call(input, hint || "default"); if (_typeof(res) !== "object") return res; throw new TypeError("@@toPrimitive must return a primitive value."); } return (hint === "string" ? String : Number)(input); }
function _regeneratorRuntime() { "use strict"; /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/facebook/regenerator/blob/main/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return exports; }; var exports = {}, Op = Object.prototype, hasOwn = Op.hasOwnProperty, defineProperty = Object.defineProperty || function (obj, key, desc) { obj[key] = desc.value; }, $Symbol = "function" == typeof Symbol ? Symbol : {}, iteratorSymbol = $Symbol.iterator || "@@iterator", asyncIteratorSymbol = $Symbol.asyncIterator || "@@asyncIterator", toStringTagSymbol = $Symbol.toStringTag || "@@toStringTag"; function define(obj, key, value) { return Object.defineProperty(obj, key, { value: value, enumerable: !0, configurable: !0, writable: !0 }), obj[key]; } try { define({}, ""); } catch (err) { define = function define(obj, key, value) { return obj[key] = value; }; } function wrap(innerFn, outerFn, self, tryLocsList) { var protoGenerator = outerFn && outerFn.prototype instanceof Generator ? outerFn : Generator, generator = Object.create(protoGenerator.prototype), context = new Context(tryLocsList || []); return defineProperty(generator, "_invoke", { value: makeInvokeMethod(innerFn, self, context) }), generator; } function tryCatch(fn, obj, arg) { try { return { type: "normal", arg: fn.call(obj, arg) }; } catch (err) { return { type: "throw", arg: err }; } } exports.wrap = wrap; var ContinueSentinel = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var IteratorPrototype = {}; define(IteratorPrototype, iteratorSymbol, function () { return this; }); var getProto = Object.getPrototypeOf, NativeIteratorPrototype = getProto && getProto(getProto(values([]))); NativeIteratorPrototype && NativeIteratorPrototype !== Op && hasOwn.call(NativeIteratorPrototype, iteratorSymbol) && (IteratorPrototype = NativeIteratorPrototype); var Gp = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(IteratorPrototype); function defineIteratorMethods(prototype) { ["next", "throw", "return"].forEach(function (method) { define(prototype, method, function (arg) { return this._invoke(method, arg); }); }); } function AsyncIterator(generator, PromiseImpl) { function invoke(method, arg, resolve, reject) { var record = tryCatch(generator[method], generator, arg); if ("throw" !== record.type) { var result = record.arg, value = result.value; return value && "object" == _typeof(value) && hasOwn.call(value, "__await") ? PromiseImpl.resolve(value.__await).then(function (value) { invoke("next", value, resolve, reject); }, function (err) { invoke("throw", err, resolve, reject); }) : PromiseImpl.resolve(value).then(function (unwrapped) { result.value = unwrapped, resolve(result); }, function (error) { return invoke("throw", error, resolve, reject); }); } reject(record.arg); } var previousPromise; defineProperty(this, "_invoke", { value: function value(method, arg) { function callInvokeWithMethodAndArg() { return new PromiseImpl(function (resolve, reject) { invoke(method, arg, resolve, reject); }); } return previousPromise = previousPromise ? previousPromise.then(callInvokeWithMethodAndArg, callInvokeWithMethodAndArg) : callInvokeWithMethodAndArg(); } }); } function makeInvokeMethod(innerFn, self, context) { var state = "suspendedStart"; return function (method, arg) { if ("executing" === state) throw new Error("Generator is already running"); if ("completed" === state) { if ("throw" === method) throw arg; return doneResult(); } for (context.method = method, context.arg = arg;;) { var delegate = context.delegate; if (delegate) { var delegateResult = maybeInvokeDelegate(delegate, context); if (delegateResult) { if (delegateResult === ContinueSentinel) continue; return delegateResult; } } if ("next" === context.method) context.sent = context._sent = context.arg;else if ("throw" === context.method) { if ("suspendedStart" === state) throw state = "completed", context.arg; context.dispatchException(context.arg); } else "return" === context.method && context.abrupt("return", context.arg); state = "executing"; var record = tryCatch(innerFn, self, context); if ("normal" === record.type) { if (state = context.done ? "completed" : "suspendedYield", record.arg === ContinueSentinel) continue; return { value: record.arg, done: context.done }; } "throw" === record.type && (state = "completed", context.method = "throw", context.arg = record.arg); } }; } function maybeInvokeDelegate(delegate, context) { var methodName = context.method, method = delegate.iterator[methodName]; if (undefined === method) return context.delegate = null, "throw" === methodName && delegate.iterator["return"] && (context.method = "return", context.arg = undefined, maybeInvokeDelegate(delegate, context), "throw" === context.method) || "return" !== methodName && (context.method = "throw", context.arg = new TypeError("The iterator does not provide a '" + methodName + "' method")), ContinueSentinel; var record = tryCatch(method, delegate.iterator, context.arg); if ("throw" === record.type) return context.method = "throw", context.arg = record.arg, context.delegate = null, ContinueSentinel; var info = record.arg; return info ? info.done ? (context[delegate.resultName] = info.value, context.next = delegate.nextLoc, "return" !== context.method && (context.method = "next", context.arg = undefined), context.delegate = null, ContinueSentinel) : info : (context.method = "throw", context.arg = new TypeError("iterator result is not an object"), context.delegate = null, ContinueSentinel); } function pushTryEntry(locs) { var entry = { tryLoc: locs[0] }; 1 in locs && (entry.catchLoc = locs[1]), 2 in locs && (entry.finallyLoc = locs[2], entry.afterLoc = locs[3]), this.tryEntries.push(entry); } function resetTryEntry(entry) { var record = entry.completion || {}; record.type = "normal", delete record.arg, entry.completion = record; } function Context(tryLocsList) { this.tryEntries = [{ tryLoc: "root" }], tryLocsList.forEach(pushTryEntry, this), this.reset(!0); } function values(iterable) { if (iterable) { var iteratorMethod = iterable[iteratorSymbol]; if (iteratorMethod) return iteratorMethod.call(iterable); if ("function" == typeof iterable.next) return iterable; if (!isNaN(iterable.length)) { var i = -1, next = function next() { for (; ++i < iterable.length;) if (hasOwn.call(iterable, i)) return next.value = iterable[i], next.done = !1, next; return next.value = undefined, next.done = !0, next; }; return next.next = next; } } return { next: doneResult }; } function doneResult() { return { value: undefined, done: !0 }; } return GeneratorFunction.prototype = GeneratorFunctionPrototype, defineProperty(Gp, "constructor", { value: GeneratorFunctionPrototype, configurable: !0 }), defineProperty(GeneratorFunctionPrototype, "constructor", { value: GeneratorFunction, configurable: !0 }), GeneratorFunction.displayName = define(GeneratorFunctionPrototype, toStringTagSymbol, "GeneratorFunction"), exports.isGeneratorFunction = function (genFun) { var ctor = "function" == typeof genFun && genFun.constructor; return !!ctor && (ctor === GeneratorFunction || "GeneratorFunction" === (ctor.displayName || ctor.name)); }, exports.mark = function (genFun) { return Object.setPrototypeOf ? Object.setPrototypeOf(genFun, GeneratorFunctionPrototype) : (genFun.__proto__ = GeneratorFunctionPrototype, define(genFun, toStringTagSymbol, "GeneratorFunction")), genFun.prototype = Object.create(Gp), genFun; }, exports.awrap = function (arg) { return { __await: arg }; }, defineIteratorMethods(AsyncIterator.prototype), define(AsyncIterator.prototype, asyncIteratorSymbol, function () { return this; }), exports.AsyncIterator = AsyncIterator, exports.async = function (innerFn, outerFn, self, tryLocsList, PromiseImpl) { void 0 === PromiseImpl && (PromiseImpl = Promise); var iter = new AsyncIterator(wrap(innerFn, outerFn, self, tryLocsList), PromiseImpl); return exports.isGeneratorFunction(outerFn) ? iter : iter.next().then(function (result) { return result.done ? result.value : iter.next(); }); }, defineIteratorMethods(Gp), define(Gp, toStringTagSymbol, "Generator"), define(Gp, iteratorSymbol, function () { return this; }), define(Gp, "toString", function () { return "[object Generator]"; }), exports.keys = function (val) { var object = Object(val), keys = []; for (var key in object) keys.push(key); return keys.reverse(), function next() { for (; keys.length;) { var key = keys.pop(); if (key in object) return next.value = key, next.done = !1, next; } return next.done = !0, next; }; }, exports.values = values, Context.prototype = { constructor: Context, reset: function reset(skipTempReset) { if (this.prev = 0, this.next = 0, this.sent = this._sent = undefined, this.done = !1, this.delegate = null, this.method = "next", this.arg = undefined, this.tryEntries.forEach(resetTryEntry), !skipTempReset) for (var name in this) "t" === name.charAt(0) && hasOwn.call(this, name) && !isNaN(+name.slice(1)) && (this[name] = undefined); }, stop: function stop() { this.done = !0; var rootRecord = this.tryEntries[0].completion; if ("throw" === rootRecord.type) throw rootRecord.arg; return this.rval; }, dispatchException: function dispatchException(exception) { if (this.done) throw exception; var context = this; function handle(loc, caught) { return record.type = "throw", record.arg = exception, context.next = loc, caught && (context.method = "next", context.arg = undefined), !!caught; } for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i], record = entry.completion; if ("root" === entry.tryLoc) return handle("end"); if (entry.tryLoc <= this.prev) { var hasCatch = hasOwn.call(entry, "catchLoc"), hasFinally = hasOwn.call(entry, "finallyLoc"); if (hasCatch && hasFinally) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } else if (hasCatch) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); } else { if (!hasFinally) throw new Error("try statement without catch or finally"); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } } } }, abrupt: function abrupt(type, arg) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc <= this.prev && hasOwn.call(entry, "finallyLoc") && this.prev < entry.finallyLoc) { var finallyEntry = entry; break; } } finallyEntry && ("break" === type || "continue" === type) && finallyEntry.tryLoc <= arg && arg <= finallyEntry.finallyLoc && (finallyEntry = null); var record = finallyEntry ? finallyEntry.completion : {}; return record.type = type, record.arg = arg, finallyEntry ? (this.method = "next", this.next = finallyEntry.finallyLoc, ContinueSentinel) : this.complete(record); }, complete: function complete(record, afterLoc) { if ("throw" === record.type) throw record.arg; return "break" === record.type || "continue" === record.type ? this.next = record.arg : "return" === record.type ? (this.rval = this.arg = record.arg, this.method = "return", this.next = "end") : "normal" === record.type && afterLoc && (this.next = afterLoc), ContinueSentinel; }, finish: function finish(finallyLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.finallyLoc === finallyLoc) return this.complete(entry.completion, entry.afterLoc), resetTryEntry(entry), ContinueSentinel; } }, "catch": function _catch(tryLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc === tryLoc) { var record = entry.completion; if ("throw" === record.type) { var thrown = record.arg; resetTryEntry(entry); } return thrown; } } throw new Error("illegal catch attempt"); }, delegateYield: function delegateYield(iterable, resultName, nextLoc) { return this.delegate = { iterator: values(iterable), resultName: resultName, nextLoc: nextLoc }, "next" === this.method && (this.arg = undefined), ContinueSentinel; } }, exports; }
function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }
function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: "AddUser",
  data: function data() {
    return {
      roles: [],
      tariffs: [],
      regions: []
    };
  },
  directives: {
    mask: vue_the_mask__WEBPACK_IMPORTED_MODULE_1__.mask
  },
  created: function created() {
    var _this = this;
    return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee() {
      return _regeneratorRuntime().wrap(function _callee$(_context) {
        while (1) switch (_context.prev = _context.next) {
          case 0:
            _this.$store.commit('setCurrentRoute', _this.$route.path.replace(/(\/*$)/, ""));
            if (!_this.isEdit) {
              _context.next = 6;
              break;
            }
            _context.next = 4;
            return _this.editItem();
          case 4:
            _context.next = 7;
            break;
          case 6:
            _this.$store.commit('setItem', {
              name: '',
              surname: '',
              middleName: '',
              email: null,
              region: null,
              phone: null,
              password: '',
              notificationsFromFavourite: true,
              notificationsFromMonitoring: true,
              notificationsToEmail: true,
              roles: ['user'],
              tariff: null
            });
          case 7:
            _context.next = 9;
            return _this.getRoles();
          case 9:
            _context.next = 11;
            return _this.getTariffs();
          case 11:
            _context.next = 13;
            return _this.getRegions();
          case 13:
          case "end":
            return _context.stop();
        }
      }, _callee);
    }))();
  },
  computed: _objectSpread(_objectSpread({}, (0,vuex__WEBPACK_IMPORTED_MODULE_2__.mapGetters)(['item', 'types'])), {}, {
    isEdit: function isEdit() {
      return !this.$route.path.includes('add');
    }
  }),
  methods: _objectSpread(_objectSpread({}, (0,vuex__WEBPACK_IMPORTED_MODULE_2__.mapActions)(['editItem', 'updateData', 'addData'])), {}, {
    storeData: function storeData(item) {
      this.addData(item);
    },
    generatePassword: function generatePassword() {
      var length = 8,
        charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",
        retVal = "";
      for (var i = 0, n = charset.length; i < length; ++i) {
        retVal += charset.charAt(Math.floor(Math.random() * n));
      }
      this.item.password = retVal;
    },
    getRoles: function getRoles() {
      var _this2 = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee2() {
        return _regeneratorRuntime().wrap(function _callee2$(_context2) {
          while (1) switch (_context2.prev = _context2.next) {
            case 0:
              _context2.next = 2;
              return axios__WEBPACK_IMPORTED_MODULE_0___default()({
                method: 'get',
                url: '/api/admin/roles',
                data: {}
              }).then(function (response) {
                _this2.roles = response.data.data;
              })["catch"](function (error) {
                console.log(error);
              });
            case 2:
            case "end":
              return _context2.stop();
          }
        }, _callee2);
      }))();
    },
    getTariffs: function getTariffs() {
      var _this3 = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee3() {
        return _regeneratorRuntime().wrap(function _callee3$(_context3) {
          while (1) switch (_context3.prev = _context3.next) {
            case 0:
              _context3.next = 2;
              return axios__WEBPACK_IMPORTED_MODULE_0___default()({
                method: 'get',
                url: '/api/admin/tariffs',
                data: {}
              }).then(function (response) {
                _this3.tariffs = response.data.data;
              })["catch"](function (error) {
                console.log(error);
              });
            case 2:
            case "end":
              return _context3.stop();
          }
        }, _callee3);
      }))();
    },
    getRegions: function getRegions() {
      var _this4 = this;
      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee4() {
        return _regeneratorRuntime().wrap(function _callee4$(_context4) {
          while (1) switch (_context4.prev = _context4.next) {
            case 0:
              _context4.next = 2;
              return axios__WEBPACK_IMPORTED_MODULE_0___default()({
                method: 'get',
                url: '/api/admin/regions',
                data: {}
              }).then(function (response) {
                _this4.regions = response.data;
              })["catch"](function (error) {
                console.log(error);
              });
            case 2:
            case "end":
              return _context4.stop();
          }
        }, _callee4);
      }))();
    }
  })
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/admin/users/AddUser.vue?vue&type=template&id=b923fd8a&scoped=true&":
/*!**************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/admin/users/AddUser.vue?vue&type=template&id=b923fd8a&scoped=true& ***!
  \**************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render),
/* harmony export */   "staticRenderFns": () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function render() {
  var _vm = this,
    _c = _vm._self._c;
  return _c('fragment', [_c('div', {
    staticClass: "content-header"
  }, [_c('div', {
    staticClass: "container-fluid"
  }, [_c('div', {
    staticClass: "row mb-2"
  }, [_c('div', {
    staticClass: "col-sm-6"
  }, [_c('h1', {
    staticClass: "m-0"
  }, [_vm._v("\n                        " + _vm._s(_vm.isEdit ? 'Редактирование данных пользователя ' : 'Добавление нового пользователя'))])]), _vm._v(" "), _c('div', {
    staticClass: "col-sm-6"
  }, [_c('ol', {
    staticClass: "breadcrumb float-sm-right"
  }, [_c('li', {
    staticClass: "breadcrumb-item"
  }, [_c('router-link', {
    staticStyle: {
      "color": "#007bff",
      "text-decoration": "none",
      "background-color": "transparent"
    },
    attrs: {
      "to": "/admin/users"
    }
  }, [_vm._v("\n                                Пользователи\n                            ")])], 1), _vm._v(" "), _c('li', {
    staticClass: "breadcrumb-item active"
  }, [_vm._v(_vm._s(_vm.isEdit ? 'Редактирование' : 'Добавление'))])])])])])]), _vm._v(" "), _c('section', {
    staticClass: "content"
  }, [_c('div', {
    staticClass: "container-fluid"
  }, [_c('div', {
    staticClass: "row"
  }, [_c('div', {
    staticClass: "col-md-12"
  }, [_c('div', {
    staticClass: "card card-primary"
  }, [_c('div', {
    staticClass: "card-body"
  }, [_c('div', {
    staticClass: "form-group"
  }, [_c('label', [_vm._v("Имя пользователя")]), _vm._v(" "), _c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.item.name,
      expression: "item.name"
    }],
    staticClass: "form-control",
    attrs: {
      "required": "",
      "name": "name",
      "type": "text",
      "placeholder": "Введите имя пользователя"
    },
    domProps: {
      "value": _vm.item.name
    },
    on: {
      "input": function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.item, "name", $event.target.value);
      }
    }
  })]), _vm._v(" "), _c('div', {
    staticClass: "form-group"
  }, [_c('label', [_vm._v("Фамилия пользователя")]), _vm._v(" "), _c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.item.surname,
      expression: "item.surname"
    }],
    staticClass: "form-control",
    attrs: {
      "required": "",
      "name": "surname",
      "type": "text",
      "placeholder": "Введите фамилию пользователя"
    },
    domProps: {
      "value": _vm.item.surname
    },
    on: {
      "input": function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.item, "surname", $event.target.value);
      }
    }
  })]), _vm._v(" "), _c('div', {
    staticClass: "form-group"
  }, [_c('label', [_vm._v("Отчество пользователя")]), _vm._v(" "), _c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.item.middleName,
      expression: "item.middleName"
    }],
    staticClass: "form-control",
    attrs: {
      "name": "middleName",
      "type": "text",
      "placeholder": "Введите отчество пользователя"
    },
    domProps: {
      "value": _vm.item.middleName
    },
    on: {
      "input": function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.item, "middleName", $event.target.value);
      }
    }
  })]), _vm._v(" "), _c('div', {
    staticClass: "form-group"
  }, [_c('label', [_vm._v("Почта (обязательно, если не задан телефон)")]), _vm._v(" "), _c('div', {
    staticClass: "input-group"
  }, [_c('div', {
    staticClass: "input-group-prepend"
  }, [_c('span', {
    staticClass: "input-group-text"
  }, [_c('i', {
    staticClass: "fas fa-envelope"
  })])]), _vm._v(" "), _c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.item.email,
      expression: "item.email"
    }],
    staticClass: "form-control",
    attrs: {
      "name": "email",
      "type": "text",
      "placeholder": "Введите почту пользователя"
    },
    domProps: {
      "value": _vm.item.email
    },
    on: {
      "input": function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.item, "email", $event.target.value);
      }
    }
  })])]), _vm._v(" "), _c('div', {
    staticClass: "form-group"
  }, [_c('label', [_vm._v("Телефон (обязательно, если не задана почта)")]), _vm._v(" "), _c('div', {
    staticClass: "input-group"
  }, [_c('div', {
    staticClass: "input-group-prepend"
  }, [_c('span', {
    staticClass: "input-group-text"
  }, [_c('i', {
    staticClass: "fa fa-phone"
  })])]), _vm._v(" "), _c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.item.phone,
      expression: "item.phone"
    }, {
      name: "mask",
      rawName: "v-mask",
      value: ['+# ### ### ####', '+## ### ### ####', '+## ### #### ####'],
      expression: "['+# ### ### ####','+## ### ### ####', '+## ### #### ####',]"
    }],
    staticClass: "form-control",
    attrs: {
      "name": "phone",
      "type": "tel",
      "placeholder": "Введите телефон пользователя"
    },
    domProps: {
      "value": _vm.item.phone
    },
    on: {
      "input": function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.item, "phone", $event.target.value);
      }
    }
  })])]), _vm._v(" "), !_vm.isEdit ? _c('div', {
    staticClass: "form-group"
  }, [_c('label', [_vm._v("Пароль пользователя (не менее 8 символов)")]), _vm._v(" "), _c('div', {
    staticClass: "input-group"
  }, [_c('div', {
    staticClass: "input-group-prepend"
  }, [_c('span', {
    staticClass: "input-group-text"
  }, [_c('i', {
    staticClass: "fa fa-key"
  })])]), _vm._v(" "), _c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.item.password,
      expression: "item.password"
    }],
    staticClass: "form-control",
    attrs: {
      "name": "password",
      "type": "text",
      "placeholder": "Введите пароль пользователя",
      "required": ""
    },
    domProps: {
      "value": _vm.item.password
    },
    on: {
      "input": function input($event) {
        if ($event.target.composing) return;
        _vm.$set(_vm.item, "password", $event.target.value);
      }
    }
  }), _vm._v(" "), _c('span', {
    staticClass: "input-group-append"
  }, [_c('button', {
    staticClass: "btn btn-info btn-flat",
    attrs: {
      "type": "button"
    },
    on: {
      "click": _vm.generatePassword
    }
  }, [_vm._v("Сгенерировать")])])])]) : _vm._e(), _vm._v(" "), !_vm.isEdit ? _c('div', {
    staticClass: "form-group"
  }, [_c('div', {
    staticClass: "custom-control custom-switch"
  }, [_c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.item.notificationsFromFavourite,
      expression: "item.notificationsFromFavourite"
    }],
    staticClass: "custom-control-input",
    attrs: {
      "type": "checkbox",
      "id": "notificationsFromFavourite"
    },
    domProps: {
      "checked": Array.isArray(_vm.item.notificationsFromFavourite) ? _vm._i(_vm.item.notificationsFromFavourite, null) > -1 : _vm.item.notificationsFromFavourite
    },
    on: {
      "change": function change($event) {
        var $$a = _vm.item.notificationsFromFavourite,
          $$el = $event.target,
          $$c = $$el.checked ? true : false;
        if (Array.isArray($$a)) {
          var $$v = null,
            $$i = _vm._i($$a, $$v);
          if ($$el.checked) {
            $$i < 0 && _vm.$set(_vm.item, "notificationsFromFavourite", $$a.concat([$$v]));
          } else {
            $$i > -1 && _vm.$set(_vm.item, "notificationsFromFavourite", $$a.slice(0, $$i).concat($$a.slice($$i + 1)));
          }
        } else {
          _vm.$set(_vm.item, "notificationsFromFavourite", $$c);
        }
      }
    }
  }), _vm._v(" "), _c('label', {
    staticClass: "custom-control-label",
    attrs: {
      "for": "notificationsFromFavourite"
    }
  }, [_vm._v("\n                                        " + _vm._s(_vm.item.notificationsFromFavourite ? 'Уведомления от избранного активированы для пользователя' : 'Уведомления от избранного отключены для пользователя') + "\n                                    ")])])]) : _vm._e(), _vm._v(" "), !_vm.isEdit ? _c('div', {
    staticClass: "form-group"
  }, [_c('div', {
    staticClass: "custom-control custom-switch"
  }, [_c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.item.notificationsFromMonitoring,
      expression: "item.notificationsFromMonitoring"
    }],
    staticClass: "custom-control-input",
    attrs: {
      "type": "checkbox",
      "id": "notificationsFromMonitoring"
    },
    domProps: {
      "checked": Array.isArray(_vm.item.notificationsFromMonitoring) ? _vm._i(_vm.item.notificationsFromMonitoring, null) > -1 : _vm.item.notificationsFromMonitoring
    },
    on: {
      "change": function change($event) {
        var $$a = _vm.item.notificationsFromMonitoring,
          $$el = $event.target,
          $$c = $$el.checked ? true : false;
        if (Array.isArray($$a)) {
          var $$v = null,
            $$i = _vm._i($$a, $$v);
          if ($$el.checked) {
            $$i < 0 && _vm.$set(_vm.item, "notificationsFromMonitoring", $$a.concat([$$v]));
          } else {
            $$i > -1 && _vm.$set(_vm.item, "notificationsFromMonitoring", $$a.slice(0, $$i).concat($$a.slice($$i + 1)));
          }
        } else {
          _vm.$set(_vm.item, "notificationsFromMonitoring", $$c);
        }
      }
    }
  }), _vm._v(" "), _c('label', {
    staticClass: "custom-control-label",
    attrs: {
      "for": "notificationsFromMonitoring"
    }
  }, [_vm._v("\n                                        " + _vm._s(_vm.item.notificationsFromMonitoring ? 'Уведомления от мониторинга активированы для пользователя' : 'Уведомления от мониторинга отключены для пользователя') + "\n                                    ")])])]) : _vm._e(), _vm._v(" "), !_vm.isEdit ? _c('div', {
    staticClass: "form-group"
  }, [_c('div', {
    staticClass: "custom-control custom-switch"
  }, [_c('input', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.item.notificationsToEmail,
      expression: "item.notificationsToEmail"
    }],
    staticClass: "custom-control-input",
    attrs: {
      "type": "checkbox",
      "id": "notificationsToEmail"
    },
    domProps: {
      "checked": Array.isArray(_vm.item.notificationsToEmail) ? _vm._i(_vm.item.notificationsToEmail, null) > -1 : _vm.item.notificationsToEmail
    },
    on: {
      "change": function change($event) {
        var $$a = _vm.item.notificationsToEmail,
          $$el = $event.target,
          $$c = $$el.checked ? true : false;
        if (Array.isArray($$a)) {
          var $$v = null,
            $$i = _vm._i($$a, $$v);
          if ($$el.checked) {
            $$i < 0 && _vm.$set(_vm.item, "notificationsToEmail", $$a.concat([$$v]));
          } else {
            $$i > -1 && _vm.$set(_vm.item, "notificationsToEmail", $$a.slice(0, $$i).concat($$a.slice($$i + 1)));
          }
        } else {
          _vm.$set(_vm.item, "notificationsToEmail", $$c);
        }
      }
    }
  }), _vm._v(" "), _c('label', {
    staticClass: "custom-control-label",
    attrs: {
      "for": "notificationsToEmail"
    }
  }, [_vm._v("\n                                        " + _vm._s(_vm.item.notificationsToEmail ? 'Уведомления на почту активированы для пользователя' : 'Уведомления на почту отключены для пользователя') + "\n                                    ")])])]) : _vm._e(), _vm._v(" "), _c('div', {
    staticClass: "form-group"
  }, [_c('label', [_vm._v("Выберите тариф для пользователя")]), _vm._v(" "), _c('div', {
    staticClass: "input-group"
  }, [_c('div', {
    staticClass: "input-group-prepend"
  }, [_c('span', {
    staticClass: "input-group-text"
  }, [_c('i', {
    staticClass: "fa fa-tags"
  })])]), _vm._v(" "), _c('select', {
    directives: [{
      name: "model",
      rawName: "v-model",
      value: _vm.item.tariff,
      expression: "item.tariff"
    }],
    staticClass: "form-control custom-select rounded-0",
    on: {
      "change": function change($event) {
        var $$selectedVal = Array.prototype.filter.call($event.target.options, function (o) {
          return o.selected;
        }).map(function (o) {
          var val = "_value" in o ? o._value : o.value;
          return val;
        });
        _vm.$set(_vm.item, "tariff", $event.target.multiple ? $$selectedVal : $$selectedVal[0]);
      }
    }
  }, [_c('option', {
    domProps: {
      "value": null
    }
  }, [_vm._v("Выберите тариф для пользователя")]), _vm._v(" "), _vm._l(_vm.tariffs, function (tariff) {
    return _c('option', {
      domProps: {
        "value": tariff.id
      }
    }, [_vm._v(_vm._s(tariff.title) + "\n                                        ")]);
  })], 2)])]), _vm._v(" "), _c('div', {
    staticClass: "form-group"
  }, [_c('label', [_vm._v("Выберите регион для пользователя")]), _vm._v(" "), _c('div', {
    staticClass: "input-group"
  }, [_c('div', {
    staticClass: "input-group-prepend"
  }, [_c('span', {
    staticClass: "input-group-text"
  }, [_c('i', {
    staticClass: "fa fa-location-arrow"
  })])]), _vm._v(" "), _c('v-select', {
    staticClass: "my-v-select",
    attrs: {
      "options": _vm.regions
    },
    model: {
      value: _vm.item.region,
      callback: function callback($$v) {
        _vm.$set(_vm.item, "region", $$v);
      },
      expression: "item.region"
    }
  })], 1)]), _vm._v(" "), _c('div', {
    staticClass: "form-group"
  }, [_c('label', [_vm._v("Роли")]), _vm._v(" "), _c('div', {
    staticClass: "input-group"
  }, [_c('div', {
    staticClass: "input-group-prepend"
  }, [_c('span', {
    staticClass: "input-group-text"
  }, [_c('i', {
    staticClass: "fa fa-users"
  })])]), _vm._v(" "), _c('v-select', {
    staticClass: "my-v-select",
    attrs: {
      "multiple": "",
      "options": _vm.roles.map(function (role) {
        return role.name;
      })
    },
    model: {
      value: _vm.item.roles,
      callback: function callback($$v) {
        _vm.$set(_vm.item, "roles", $$v);
      },
      expression: "item.roles"
    }
  })], 1)]), _vm._v(" "), _c('button', {
    staticClass: "btn btn-success float-right",
    attrs: {
      "type": "submit"
    },
    on: {
      "click": function click($event) {
        _vm.isEdit ? _vm.updateData(_vm.item) : _vm.storeData(_vm.item);
      }
    }
  }, [_vm._v("Сохранить\n                            ")])])])])])])])]);
};
var staticRenderFns = [];


/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/admin/users/AddUser.vue?vue&type=style&index=0&id=b923fd8a&prod&scoped=true&lang=css&":
/*!****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/admin/users/AddUser.vue?vue&type=style&index=0&id=b923fd8a&prod&scoped=true&lang=css& ***!
  \****************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((module, __webpack_exports__, __webpack_require__) => {

/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_css_loader_dist_runtime_cssWithMappingToString_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../../node_modules/css-loader/dist/runtime/cssWithMappingToString.js */ "./node_modules/css-loader/dist/runtime/cssWithMappingToString.js");
/* harmony import */ var _node_modules_css_loader_dist_runtime_cssWithMappingToString_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_css_loader_dist_runtime_cssWithMappingToString_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../../../node_modules/css-loader/dist/runtime/api.js */ "./node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_1__);
// Imports


var ___CSS_LOADER_EXPORT___ = _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_1___default()((_node_modules_css_loader_dist_runtime_cssWithMappingToString_js__WEBPACK_IMPORTED_MODULE_0___default()));
// Module
___CSS_LOADER_EXPORT___.push([module.id, ".my-v-select[data-v-b923fd8a]{flex:1 1 auto;min-width:0;position:relative;width:1%}", "",{"version":3,"sources":["webpack://./resources/js/admin/users/AddUser.vue"],"names":[],"mappings":"AA4RA,8BAEA,aAAA,CAEA,WAAA,CAHA,iBAAA,CAEA,QAEA","sourcesContent":["<template>\r\n    <fragment>\r\n        <div class=\"content-header\">\r\n            <div class=\"container-fluid\">\r\n                <div class=\"row mb-2\">\r\n                    <div class=\"col-sm-6\">\r\n                        <h1 class=\"m-0\">\r\n                            {{ isEdit ? 'Редактирование данных пользователя ' : 'Добавление нового пользователя' }}</h1>\r\n                    </div>\r\n                    <div class=\"col-sm-6\">\r\n                        <ol class=\"breadcrumb float-sm-right\">\r\n                            <li class=\"breadcrumb-item\">\r\n                                <router-link to=\"/admin/users\"\r\n                                             style=\"color: #007bff; text-decoration: none; background-color: transparent;\">\r\n                                    Пользователи\r\n                                </router-link>\r\n                            </li>\r\n                            <li class=\"breadcrumb-item active\">{{ isEdit ? 'Редактирование' : 'Добавление' }}</li>\r\n                        </ol>\r\n                    </div>\r\n                </div>\r\n            </div>\r\n        </div>\r\n\r\n        <section class=\"content\">\r\n            <div class=\"container-fluid\">\r\n                <div class=\"row\">\r\n                    <div class=\"col-md-12\">\r\n                        <div class=\"card card-primary\">\r\n                            <div class=\"card-body\">\r\n                                <div class=\"form-group\">\r\n                                    <label>Имя пользователя</label>\r\n                                    <input required name=\"name\" type=\"text\" class=\"form-control\" v-model=\"item.name\"\r\n                                           placeholder=\"Введите имя пользователя\">\r\n                                </div>\r\n                                <div class=\"form-group\">\r\n                                    <label>Фамилия пользователя</label>\r\n                                    <input required name=\"surname\" type=\"text\" class=\"form-control\"\r\n                                           v-model=\"item.surname\"\r\n                                           placeholder=\"Введите фамилию пользователя\">\r\n                                </div>\r\n                                <div class=\"form-group\">\r\n                                    <label>Отчество пользователя</label>\r\n                                    <input name=\"middleName\" type=\"text\" class=\"form-control\" v-model=\"item.middleName\"\r\n                                           placeholder=\"Введите отчество пользователя\">\r\n                                </div>\r\n                                <div class=\"form-group\">\r\n                                    <label>Почта (обязательно, если не задан телефон)</label>\r\n                                    <div class=\"input-group\">\r\n                                        <div class=\"input-group-prepend\">\r\n                                            <span class=\"input-group-text\"><i class=\"fas fa-envelope\"></i></span>\r\n                                        </div>\r\n                                        <input name=\"email\" type=\"text\" class=\"form-control\" v-model=\"item.email\"\r\n                                               placeholder=\"Введите почту пользователя\">\r\n                                    </div>\r\n                                </div>\r\n                                <div class=\"form-group\">\r\n                                    <label>Телефон (обязательно, если не задана почта)</label>\r\n                                    <div class=\"input-group\">\r\n                                        <div class=\"input-group-prepend\">\r\n                                            <span class=\"input-group-text\"><i class=\"fa fa-phone\"></i></span>\r\n                                        </div>\r\n                                        <input name=\"phone\" type=\"tel\" class=\"form-control\" v-model=\"item.phone\"\r\n                                               v-mask=\"['+# ### ### ####','+## ### ### ####', '+## ### #### ####',]\"\r\n                                               placeholder=\"Введите телефон пользователя\">\r\n                                    </div>\r\n                                </div>\r\n                                <div class=\"form-group\" v-if=\"!isEdit\">\r\n                                    <label>Пароль пользователя (не менее 8 символов)</label>\r\n                                    <div class=\"input-group\">\r\n                                        <div class=\"input-group-prepend\">\r\n                                            <span class=\"input-group-text\"><i class=\"fa fa-key\"></i></span>\r\n                                        </div>\r\n                                        <input name=\"password\" type=\"text\" class=\"form-control\" v-model=\"item.password\"\r\n                                               placeholder=\"Введите пароль пользователя\" required>\r\n                                        <span class=\"input-group-append\">\r\n                                        <button type=\"button\" class=\"btn btn-info btn-flat\"\r\n                                                @click=\"generatePassword\">Сгенерировать</button>\r\n                                    </span>\r\n                                    </div>\r\n\r\n                                </div>\r\n\r\n                                <div class=\"form-group\" v-if=\"!isEdit\">\r\n                                    <div class=\"custom-control custom-switch\">\r\n                                        <input type=\"checkbox\" class=\"custom-control-input\"\r\n                                               id=\"notificationsFromFavourite\"\r\n                                               v-model=\"item.notificationsFromFavourite\">\r\n                                        <label class=\"custom-control-label\" for=\"notificationsFromFavourite\">\r\n                                            {{\r\n                                                item.notificationsFromFavourite ? 'Уведомления от избранного активированы для пользователя' :\r\n                                                    'Уведомления от избранного отключены для пользователя'\r\n                                            }}\r\n                                        </label>\r\n                                    </div>\r\n                                </div>\r\n\r\n                                <div class=\"form-group\" v-if=\"!isEdit\">\r\n                                    <div class=\"custom-control custom-switch\">\r\n                                        <input type=\"checkbox\" class=\"custom-control-input\"\r\n                                               id=\"notificationsFromMonitoring\"\r\n                                               v-model=\"item.notificationsFromMonitoring\">\r\n                                        <label class=\"custom-control-label\" for=\"notificationsFromMonitoring\">\r\n                                            {{\r\n                                                item.notificationsFromMonitoring ? 'Уведомления от мониторинга активированы для пользователя' :\r\n                                                    'Уведомления от мониторинга отключены для пользователя'\r\n                                            }}\r\n                                        </label>\r\n                                    </div>\r\n                                </div>\r\n\r\n                                <div class=\"form-group\" v-if=\"!isEdit\">\r\n                                    <div class=\"custom-control custom-switch\">\r\n                                        <input type=\"checkbox\" class=\"custom-control-input\" id=\"notificationsToEmail\"\r\n                                               v-model=\"item.notificationsToEmail\">\r\n                                        <label class=\"custom-control-label\" for=\"notificationsToEmail\">\r\n                                            {{\r\n                                                item.notificationsToEmail ? 'Уведомления на почту активированы для пользователя' :\r\n                                                    'Уведомления на почту отключены для пользователя'\r\n                                            }}\r\n                                        </label>\r\n                                    </div>\r\n                                </div>\r\n\r\n                                <div class=\"form-group\">\r\n                                    <label>Выберите тариф для пользователя</label>\r\n                                    <div class=\"input-group\">\r\n                                        <div class=\"input-group-prepend\">\r\n                                            <span class=\"input-group-text\"><i class=\"fa fa-tags\"></i></span>\r\n                                        </div>\r\n                                        <select class=\"form-control custom-select rounded-0\" v-model=\"item.tariff\">\r\n                                            <option :value=\"null\">Выберите тариф для пользователя</option>\r\n                                            <option v-for=\"tariff in tariffs\" :value=\"tariff.id\">{{\r\n                                                    tariff.title\r\n                                                }}\r\n                                            </option>\r\n                                        </select>\r\n                                    </div>\r\n                                </div>\r\n\r\n                                <div class=\"form-group\">\r\n                                    <label>Выберите регион для пользователя</label>\r\n                                    <div class=\"input-group\">\r\n                                        <div class=\"input-group-prepend\">\r\n                                            <span class=\"input-group-text\"><i class=\"fa fa-location-arrow\"></i></span>\r\n                                        </div>\r\n                                    <v-select\r\n                                        class=\"my-v-select\"\r\n                                        v-model=\"item.region\"\r\n                                        :options=\"regions\"\r\n                                    >\r\n                                    </v-select>\r\n                                    </div>\r\n                                </div>\r\n\r\n                                <div class=\"form-group\">\r\n                                    <label>Роли</label>\r\n                                    <div class=\"input-group\">\r\n                                        <div class=\"input-group-prepend\">\r\n                                            <span class=\"input-group-text\"><i class=\"fa fa-users\"></i></span>\r\n                                        </div>\r\n                                        <v-select\r\n                                            class=\"my-v-select\"\r\n                                            multiple\r\n                                            v-model=\"item.roles\"\r\n                                            :options=\"roles.map(role=>role.name)\"\r\n\r\n                                        >\r\n                                        </v-select>\r\n                                    </div>\r\n\r\n                                </div>\r\n\r\n                                <button type=\"submit\" class=\"btn btn-success float-right\"\r\n                                        @click=\"isEdit ? updateData(item) : storeData(item)\">Сохранить\r\n                                </button>\r\n                            </div>\r\n                            <!-- /.card-body -->\r\n                        </div>\r\n                        <!-- /.card -->\r\n                    </div>\r\n                </div>\r\n            </div>\r\n        </section>\r\n    </fragment>\r\n</template>\r\n\r\n<script>\r\nimport {mapActions, mapGetters} from \"vuex\";\r\nimport axios from \"axios\";\r\nimport {mask} from 'vue-the-mask'\r\nexport default {\r\n    name: \"AddUser\",\r\n    data() {\r\n        return {\r\n            roles: [],\r\n            tariffs: [],\r\n            regions: []\r\n        }\r\n    },\r\n    directives:{mask},\r\n    async created() {\r\n        this.$store.commit('setCurrentRoute', this.$route.path.replace(/(\\/*$)/, \"\"))\r\n        if (this.isEdit) {\r\n            await this.editItem()\r\n        } else {\r\n            this.$store.commit('setItem',\r\n                {\r\n                    name: '', surname: '', middleName: '', email: null, region: null,\r\n                    phone: null, password: '', notificationsFromFavourite: true, notificationsFromMonitoring: true,\r\n                    notificationsToEmail: true, roles: ['user'], tariff: null\r\n                }\r\n            )\r\n        }\r\n        await this.getRoles()\r\n        await this.getTariffs()\r\n        await this.getRegions()\r\n    },\r\n    computed: {\r\n        ...mapGetters(['item', 'types']),\r\n        isEdit() {\r\n            return !this.$route.path.includes('add')\r\n        }\r\n    },\r\n    methods: {\r\n        ...mapActions(['editItem', 'updateData', 'addData']),\r\n        storeData(item) {\r\n            this.addData(item)\r\n\r\n        },\r\n        generatePassword() {\r\n            let length = 8,\r\n                charset = \"abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789\",\r\n                retVal = \"\";\r\n            for (let i = 0, n = charset.length; i < length; ++i) {\r\n                retVal += charset.charAt(Math.floor(Math.random() * n));\r\n            }\r\n            this.item.password = retVal;\r\n        },\r\n        async getRoles() {\r\n            await axios({\r\n                method: 'get',\r\n                url: '/api/admin/roles',\r\n                data: {},\r\n            })\r\n                .then((response) => {\r\n                    this.roles = response.data.data\r\n                })\r\n                .catch((error) => {\r\n                    console.log(error);\r\n                });\r\n        },\r\n        async getTariffs() {\r\n            await axios({\r\n                method: 'get',\r\n                url: '/api/admin/tariffs',\r\n                data: {},\r\n            })\r\n                .then((response) => {\r\n                    this.tariffs = response.data.data\r\n                })\r\n                .catch((error) => {\r\n                    console.log(error);\r\n                });\r\n        },\r\n        async getRegions() {\r\n            await axios({\r\n                method: 'get',\r\n                url: '/api/admin/regions',\r\n                data: {},\r\n            })\r\n                .then((response) => {\r\n                    this.regions = response.data\r\n                })\r\n                .catch((error) => {\r\n                    console.log(error);\r\n                });\r\n        }\r\n    }\r\n\r\n}\r\n</script>\r\n\r\n<style scoped>\r\n.my-v-select {\r\n    position: relative;\r\n    flex: 1 1 auto;\r\n    width: 1%;\r\n    min-width: 0;\r\n}\r\n</style>\r\n"],"sourceRoot":""}]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/admin/users/AddUser.vue?vue&type=style&index=0&id=b923fd8a&prod&scoped=true&lang=css&":
/*!********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/admin/users/AddUser.vue?vue&type=style&index=0&id=b923fd8a&prod&scoped=true&lang=css& ***!
  \********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __unused_webpack___webpack_exports__, __webpack_require__) => {

/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_AddUser_vue_vue_type_style_index_0_id_b923fd8a_prod_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./AddUser.vue?vue&type=style&index=0&id=b923fd8a&prod&scoped=true&lang=css& */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/admin/users/AddUser.vue?vue&type=style&index=0&id=b923fd8a&prod&scoped=true&lang=css&");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_AddUser_vue_vue_type_style_index_0_id_b923fd8a_prod_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__["default"], options);



/* unused harmony default export */ var __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_AddUser_vue_vue_type_style_index_0_id_b923fd8a_prod_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__["default"].locals || {});

/***/ }),

/***/ "./resources/js/admin/users/AddUser.vue":
/*!**********************************************!*\
  !*** ./resources/js/admin/users/AddUser.vue ***!
  \**********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _AddUser_vue_vue_type_template_id_b923fd8a_scoped_true___WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./AddUser.vue?vue&type=template&id=b923fd8a&scoped=true& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/admin/users/AddUser.vue?vue&type=template&id=b923fd8a&scoped=true&");
/* harmony import */ var _AddUser_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./AddUser.vue?vue&type=script&lang=js& */ "./resources/js/admin/users/AddUser.vue?vue&type=script&lang=js&");
/* harmony import */ var _AddUser_vue_vue_type_style_index_0_id_b923fd8a_prod_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./AddUser.vue?vue&type=style&index=0&id=b923fd8a&prod&scoped=true&lang=css& */ "./resources/js/admin/users/AddUser.vue?vue&type=style&index=0&id=b923fd8a&prod&scoped=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");



;


/* normalize component */

var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _AddUser_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"],
  _AddUser_vue_vue_type_template_id_b923fd8a_scoped_true___WEBPACK_IMPORTED_MODULE_3__.render,
  _AddUser_vue_vue_type_template_id_b923fd8a_scoped_true___WEBPACK_IMPORTED_MODULE_3__.staticRenderFns,
  false,
  null,
  "b923fd8a",
  null
  
)

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/admin/users/AddUser.vue?vue&type=script&lang=js&":
/*!***********************************************************************!*\
  !*** ./resources/js/admin/users/AddUser.vue?vue&type=script&lang=js& ***!
  \***********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_AddUser_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./AddUser.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/admin/users/AddUser.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_AddUser_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/admin/users/AddUser.vue?vue&type=style&index=0&id=b923fd8a&prod&scoped=true&lang=css&":
/*!************************************************************************************************************!*\
  !*** ./resources/js/admin/users/AddUser.vue?vue&type=style&index=0&id=b923fd8a&prod&scoped=true&lang=css& ***!
  \************************************************************************************************************/
/***/ ((__unused_webpack_module, __unused_webpack___webpack_exports__, __webpack_require__) => {

/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_lib_index_js_vue_loader_options_AddUser_vue_vue_type_style_index_0_id_b923fd8a_prod_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/style-loader/dist/cjs.js!../../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./AddUser.vue?vue&type=style&index=0&id=b923fd8a&prod&scoped=true&lang=css& */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/admin/users/AddUser.vue?vue&type=style&index=0&id=b923fd8a&prod&scoped=true&lang=css&");


/***/ })

}]);
//# sourceMappingURL=users-add.js.map