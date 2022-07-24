"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["favourites"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Favourites.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Favourites.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Favourites_AddPathModal__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Favourites/AddPathModal */ "./resources/js/pages/Favourites/AddPathModal.vue");
/* harmony import */ var _Favourites_EditPathModal__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Favourites/EditPathModal */ "./resources/js/pages/Favourites/EditPathModal.vue");
/* harmony import */ var _Favourites_MoveFavouriteModal__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./Favourites/MoveFavouriteModal */ "./resources/js/pages/Favourites/MoveFavouriteModal.vue");
/* harmony import */ var _components_Select__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../components/Select */ "./resources/js/components/Select.vue");
/* harmony import */ var _components_Collapse__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../components/Collapse */ "./resources/js/components/Collapse.vue");
/* harmony import */ var _Favourites_AddFieldsToDocument__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./Favourites/AddFieldsToDocument */ "./resources/js/pages/Favourites/AddFieldsToDocument.vue");
function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }

function _regeneratorRuntime() { "use strict"; /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/facebook/regenerator/blob/main/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return exports; }; var exports = {}, Op = Object.prototype, hasOwn = Op.hasOwnProperty, $Symbol = "function" == typeof Symbol ? Symbol : {}, iteratorSymbol = $Symbol.iterator || "@@iterator", asyncIteratorSymbol = $Symbol.asyncIterator || "@@asyncIterator", toStringTagSymbol = $Symbol.toStringTag || "@@toStringTag"; function define(obj, key, value) { return Object.defineProperty(obj, key, { value: value, enumerable: !0, configurable: !0, writable: !0 }), obj[key]; } try { define({}, ""); } catch (err) { define = function define(obj, key, value) { return obj[key] = value; }; } function wrap(innerFn, outerFn, self, tryLocsList) { var protoGenerator = outerFn && outerFn.prototype instanceof Generator ? outerFn : Generator, generator = Object.create(protoGenerator.prototype), context = new Context(tryLocsList || []); return generator._invoke = function (innerFn, self, context) { var state = "suspendedStart"; return function (method, arg) { if ("executing" === state) throw new Error("Generator is already running"); if ("completed" === state) { if ("throw" === method) throw arg; return doneResult(); } for (context.method = method, context.arg = arg;;) { var delegate = context.delegate; if (delegate) { var delegateResult = maybeInvokeDelegate(delegate, context); if (delegateResult) { if (delegateResult === ContinueSentinel) continue; return delegateResult; } } if ("next" === context.method) context.sent = context._sent = context.arg;else if ("throw" === context.method) { if ("suspendedStart" === state) throw state = "completed", context.arg; context.dispatchException(context.arg); } else "return" === context.method && context.abrupt("return", context.arg); state = "executing"; var record = tryCatch(innerFn, self, context); if ("normal" === record.type) { if (state = context.done ? "completed" : "suspendedYield", record.arg === ContinueSentinel) continue; return { value: record.arg, done: context.done }; } "throw" === record.type && (state = "completed", context.method = "throw", context.arg = record.arg); } }; }(innerFn, self, context), generator; } function tryCatch(fn, obj, arg) { try { return { type: "normal", arg: fn.call(obj, arg) }; } catch (err) { return { type: "throw", arg: err }; } } exports.wrap = wrap; var ContinueSentinel = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var IteratorPrototype = {}; define(IteratorPrototype, iteratorSymbol, function () { return this; }); var getProto = Object.getPrototypeOf, NativeIteratorPrototype = getProto && getProto(getProto(values([]))); NativeIteratorPrototype && NativeIteratorPrototype !== Op && hasOwn.call(NativeIteratorPrototype, iteratorSymbol) && (IteratorPrototype = NativeIteratorPrototype); var Gp = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(IteratorPrototype); function defineIteratorMethods(prototype) { ["next", "throw", "return"].forEach(function (method) { define(prototype, method, function (arg) { return this._invoke(method, arg); }); }); } function AsyncIterator(generator, PromiseImpl) { function invoke(method, arg, resolve, reject) { var record = tryCatch(generator[method], generator, arg); if ("throw" !== record.type) { var result = record.arg, value = result.value; return value && "object" == _typeof(value) && hasOwn.call(value, "__await") ? PromiseImpl.resolve(value.__await).then(function (value) { invoke("next", value, resolve, reject); }, function (err) { invoke("throw", err, resolve, reject); }) : PromiseImpl.resolve(value).then(function (unwrapped) { result.value = unwrapped, resolve(result); }, function (error) { return invoke("throw", error, resolve, reject); }); } reject(record.arg); } var previousPromise; this._invoke = function (method, arg) { function callInvokeWithMethodAndArg() { return new PromiseImpl(function (resolve, reject) { invoke(method, arg, resolve, reject); }); } return previousPromise = previousPromise ? previousPromise.then(callInvokeWithMethodAndArg, callInvokeWithMethodAndArg) : callInvokeWithMethodAndArg(); }; } function maybeInvokeDelegate(delegate, context) { var method = delegate.iterator[context.method]; if (undefined === method) { if (context.delegate = null, "throw" === context.method) { if (delegate.iterator["return"] && (context.method = "return", context.arg = undefined, maybeInvokeDelegate(delegate, context), "throw" === context.method)) return ContinueSentinel; context.method = "throw", context.arg = new TypeError("The iterator does not provide a 'throw' method"); } return ContinueSentinel; } var record = tryCatch(method, delegate.iterator, context.arg); if ("throw" === record.type) return context.method = "throw", context.arg = record.arg, context.delegate = null, ContinueSentinel; var info = record.arg; return info ? info.done ? (context[delegate.resultName] = info.value, context.next = delegate.nextLoc, "return" !== context.method && (context.method = "next", context.arg = undefined), context.delegate = null, ContinueSentinel) : info : (context.method = "throw", context.arg = new TypeError("iterator result is not an object"), context.delegate = null, ContinueSentinel); } function pushTryEntry(locs) { var entry = { tryLoc: locs[0] }; 1 in locs && (entry.catchLoc = locs[1]), 2 in locs && (entry.finallyLoc = locs[2], entry.afterLoc = locs[3]), this.tryEntries.push(entry); } function resetTryEntry(entry) { var record = entry.completion || {}; record.type = "normal", delete record.arg, entry.completion = record; } function Context(tryLocsList) { this.tryEntries = [{ tryLoc: "root" }], tryLocsList.forEach(pushTryEntry, this), this.reset(!0); } function values(iterable) { if (iterable) { var iteratorMethod = iterable[iteratorSymbol]; if (iteratorMethod) return iteratorMethod.call(iterable); if ("function" == typeof iterable.next) return iterable; if (!isNaN(iterable.length)) { var i = -1, next = function next() { for (; ++i < iterable.length;) { if (hasOwn.call(iterable, i)) return next.value = iterable[i], next.done = !1, next; } return next.value = undefined, next.done = !0, next; }; return next.next = next; } } return { next: doneResult }; } function doneResult() { return { value: undefined, done: !0 }; } return GeneratorFunction.prototype = GeneratorFunctionPrototype, define(Gp, "constructor", GeneratorFunctionPrototype), define(GeneratorFunctionPrototype, "constructor", GeneratorFunction), GeneratorFunction.displayName = define(GeneratorFunctionPrototype, toStringTagSymbol, "GeneratorFunction"), exports.isGeneratorFunction = function (genFun) { var ctor = "function" == typeof genFun && genFun.constructor; return !!ctor && (ctor === GeneratorFunction || "GeneratorFunction" === (ctor.displayName || ctor.name)); }, exports.mark = function (genFun) { return Object.setPrototypeOf ? Object.setPrototypeOf(genFun, GeneratorFunctionPrototype) : (genFun.__proto__ = GeneratorFunctionPrototype, define(genFun, toStringTagSymbol, "GeneratorFunction")), genFun.prototype = Object.create(Gp), genFun; }, exports.awrap = function (arg) { return { __await: arg }; }, defineIteratorMethods(AsyncIterator.prototype), define(AsyncIterator.prototype, asyncIteratorSymbol, function () { return this; }), exports.AsyncIterator = AsyncIterator, exports.async = function (innerFn, outerFn, self, tryLocsList, PromiseImpl) { void 0 === PromiseImpl && (PromiseImpl = Promise); var iter = new AsyncIterator(wrap(innerFn, outerFn, self, tryLocsList), PromiseImpl); return exports.isGeneratorFunction(outerFn) ? iter : iter.next().then(function (result) { return result.done ? result.value : iter.next(); }); }, defineIteratorMethods(Gp), define(Gp, toStringTagSymbol, "Generator"), define(Gp, iteratorSymbol, function () { return this; }), define(Gp, "toString", function () { return "[object Generator]"; }), exports.keys = function (object) { var keys = []; for (var key in object) { keys.push(key); } return keys.reverse(), function next() { for (; keys.length;) { var key = keys.pop(); if (key in object) return next.value = key, next.done = !1, next; } return next.done = !0, next; }; }, exports.values = values, Context.prototype = { constructor: Context, reset: function reset(skipTempReset) { if (this.prev = 0, this.next = 0, this.sent = this._sent = undefined, this.done = !1, this.delegate = null, this.method = "next", this.arg = undefined, this.tryEntries.forEach(resetTryEntry), !skipTempReset) for (var name in this) { "t" === name.charAt(0) && hasOwn.call(this, name) && !isNaN(+name.slice(1)) && (this[name] = undefined); } }, stop: function stop() { this.done = !0; var rootRecord = this.tryEntries[0].completion; if ("throw" === rootRecord.type) throw rootRecord.arg; return this.rval; }, dispatchException: function dispatchException(exception) { if (this.done) throw exception; var context = this; function handle(loc, caught) { return record.type = "throw", record.arg = exception, context.next = loc, caught && (context.method = "next", context.arg = undefined), !!caught; } for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i], record = entry.completion; if ("root" === entry.tryLoc) return handle("end"); if (entry.tryLoc <= this.prev) { var hasCatch = hasOwn.call(entry, "catchLoc"), hasFinally = hasOwn.call(entry, "finallyLoc"); if (hasCatch && hasFinally) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } else if (hasCatch) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); } else { if (!hasFinally) throw new Error("try statement without catch or finally"); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } } } }, abrupt: function abrupt(type, arg) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc <= this.prev && hasOwn.call(entry, "finallyLoc") && this.prev < entry.finallyLoc) { var finallyEntry = entry; break; } } finallyEntry && ("break" === type || "continue" === type) && finallyEntry.tryLoc <= arg && arg <= finallyEntry.finallyLoc && (finallyEntry = null); var record = finallyEntry ? finallyEntry.completion : {}; return record.type = type, record.arg = arg, finallyEntry ? (this.method = "next", this.next = finallyEntry.finallyLoc, ContinueSentinel) : this.complete(record); }, complete: function complete(record, afterLoc) { if ("throw" === record.type) throw record.arg; return "break" === record.type || "continue" === record.type ? this.next = record.arg : "return" === record.type ? (this.rval = this.arg = record.arg, this.method = "return", this.next = "end") : "normal" === record.type && afterLoc && (this.next = afterLoc), ContinueSentinel; }, finish: function finish(finallyLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.finallyLoc === finallyLoc) return this.complete(entry.completion, entry.afterLoc), resetTryEntry(entry), ContinueSentinel; } }, "catch": function _catch(tryLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc === tryLoc) { var record = entry.completion; if ("throw" === record.type) { var thrown = record.arg; resetTryEntry(entry); } return thrown; } } throw new Error("illegal catch attempt"); }, delegateYield: function delegateYield(iterable, resultName, nextLoc) { return this.delegate = { iterator: values(iterable), resultName: resultName, nextLoc: nextLoc }, "next" === this.method && (this.arg = undefined), ContinueSentinel; } }, exports; }

function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//






/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: "Favourites",
  components: {
    'bkt-select': _components_Select__WEBPACK_IMPORTED_MODULE_3__["default"],
    'bkt-add-path-modal': _Favourites_AddPathModal__WEBPACK_IMPORTED_MODULE_0__["default"],
    'bkt-edit-path-modal': _Favourites_EditPathModal__WEBPACK_IMPORTED_MODULE_1__["default"],
    'bkt-move-favourite-modal': _Favourites_MoveFavouriteModal__WEBPACK_IMPORTED_MODULE_2__["default"],
    'bkt-excel-modal': _Favourites_AddFieldsToDocument__WEBPACK_IMPORTED_MODULE_5__["default"],
    BktCollapse: _components_Collapse__WEBPACK_IMPORTED_MODULE_4__["default"]
  },
  created: function created() {
    this.getFavouritePaths(); // this.getData();
  },
  mounted: function mounted() {},
  data: function data() {
    return {
      loading: false,
      search_mode: false,
      selectedBtn: 0,
      group: 'по порядку добавления',
      to_group: [{
        title: 'по порядку добавления',
        value: "publishDate"
      }, {
        title: 'по порядку добавления2',
        value: "publishDate1"
      }, {
        title: 'по порядку добавления3s',
        value: "publishDate2"
      }],
      settings: {
        "dots": false,
        "infinite": false,
        "centerMode": false,
        "centerPadding": "20px",
        "slidesToShow": 1,
        "slidesToScroll": 1,
        "variableWidth": true
      }
    };
  },
  computed: {
    items: function items() {
      return this.$store.getters.current_favourites;
    },
    pagination_data: function pagination_data() {
      return this.$store.getters.favourites_pagination;
    },
    // favourites_loading() {
    //     return this.$store.getters.favourites_loading;
    // },
    items_paths: function items_paths() {
      return this.$store.getters.favourites_paths;
    },
    current_path: function current_path() {
      return this.$store.getters.current_path;
    },
    current_path_object: function current_path_object() {
      var _this = this;

      var index = this.items_paths.findIndex(function (item) {
        return item.pathId == _this.current_path;
      });

      if (index >= 0) {
        return this.items_paths[index];
      }

      return {};
    },
    // current_path: {
    //     get() {
    //         return this.$store.getters.current_path;
    //     },
    //     set(value) {
    //         this.$store.dispatch('setCurrentPath', value);
    //     }
    // },
    method_params: function method_params() {
      return {
        pathId: this.current_path
      };
    }
  },
  methods: {
    getData: function getData() {
      var _arguments = arguments,
          _this2 = this;

      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee() {
        var page, pathId;
        return _regeneratorRuntime().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                page = _arguments.length > 0 && _arguments[0] !== undefined ? _arguments[0] : 1;
                pathId = _arguments.length > 1 ? _arguments[1] : undefined;
                _context.next = 4;
                return _this2.$store.dispatch('getFavourites', {
                  page: page,
                  pathId: pathId
                });

              case 4:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    getFavouritePaths: function getFavouritePaths() {
      var _this3 = this;

      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee2() {
        return _regeneratorRuntime().wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                _this3.loading = true;
                _context2.next = 3;
                return _this3.$store.dispatch('getFavouritePaths').then(function (response) {
                  // this.$store.commit('setFavouritePaths', response.data)
                  // this.$store.commit('setCurrentPath', response.data[0].pathId)
                  // this.getData(1, this.current_path)
                  _this3.$store.dispatch('getFavourites', {
                    page: 1,
                    pathId: _this3.current_path
                  })["finally"](function () {
                    _this3.loading = false;
                  });
                })["catch"](function (err) {
                  _this3.loading = false;
                });

              case 3:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2);
      }))();
    },
    setCurrentPath: function setCurrentPath(value) {
      var _this4 = this;

      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee3() {
        return _regeneratorRuntime().wrap(function _callee3$(_context3) {
          while (1) {
            switch (_context3.prev = _context3.next) {
              case 0:
                _this4.loading = true;
                _context3.next = 3;
                return _this4.$store.dispatch('setCurrentPath', value)["finally"](function () {
                  _this4.loading = false;
                });

              case 3:
              case "end":
                return _context3.stop();
            }
          }
        }, _callee3);
      }))();
    },
    removeFavouritePath: function removeFavouritePath() {
      var _this5 = this;

      return _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee4() {
        return _regeneratorRuntime().wrap(function _callee4$(_context4) {
          while (1) {
            switch (_context4.prev = _context4.next) {
              case 0:
                _context4.next = 2;
                return _this5.$store.dispatch('removeFavouritePath', _this5.current_path).then(function (resp) {
                  _this5.setCurrentPath(_this5.items_paths[0].pathId);
                });

              case 2:
              case "end":
                return _context4.stop();
            }
          }
        }, _callee4);
      }))();
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Favourites/AddFieldsToDocument.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Favourites/AddFieldsToDocument.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: "AddFieldsToDocument",
  data: function data() {
    return {
      loading: false,
      fields: [{
        "title": "Номер торгов",
        code: 'addTradeNumber'
      }, {
        "title": "Ссылка ЕФРС",
        code: 'addEfrsbLink'
      }, {
        "title": "Наименование лота",
        code: 'addDescription'
      }, {
        "title": "Текущая цена",
        code: 'addCurrentPrice'
      }, {
        "title": "Тип торгов",
        code: 'addAuctionType'
      }, {
        "title": "Должник",
        code: 'addDebtor'
      }, {
        "title": "Арбитражный управляющий",
        code: 'addArbitrationManager'
      }, {
        "title": "Начало подачи заявок",
        code: 'addApplicationStart'
      }, {
        "title": "Окончание подачи заявок",
        code: 'addApplicationEnd'
      }, {
        "title": "Победитель торгов",
        code: 'addWinner'
      }, {
        "title": "Номер лота",
        code: 'addLotNumber'
      }, {
        "title": "Ссылка и название ЭТП",
        code: 'addTradePlace'
      }, {
        "title": "Начальная цена",
        code: 'addStartPrice'
      }, {
        "title": "Минимальная цена",
        code: 'addMinPrice'
      }, {
        "title": "Регион",
        code: 'addRegion'
      }, {
        "title": "Организатор",
        code: 'addOrganizer'
      }, {
        "title": "Начало торгов",
        code: 'addEventStart'
      }, {
        "title": "Окончание торгов",
        code: 'addEventEnd'
      }, {
        "title": "Заметка по лоту",
        code: 'addNote'
      }],
      doc: {
        "addTradeNumber": false,
        "addEfrsbLink": false,
        "addDescription": false,
        "addCurrentPrice": false,
        "addAuctionType": false,
        "addDebtor": false,
        "addArbitrationManager": false,
        "addApplicationStart": false,
        "addApplicationEnd": false,
        "addWinner": false,
        "addLotNumber": false,
        "addTradePlace": false,
        "addStartPrice": false,
        "addMinPrice": false,
        "addRegion": false,
        "addOrganizer": false,
        "addEventStart": false,
        "addEventEnd": false,
        "addNote": false
      }
    };
  },
  computed: {
    current_path: function current_path() {
      return this.$store.getters.current_path;
    }
  },
  methods: {
    selectAllFields: function selectAllFields() {
      var _this = this;

      this.fields.forEach(function (item) {
        _this.doc[item.code] = true;
      });
    },
    removeAllFields: function removeAllFields() {
      var _this2 = this;

      this.fields.forEach(function (item) {
        _this2.doc[item.code] = false;
      });
    },
    download: function download() {
      var _this3 = this;

      this.loading = true;
      this.doc.pathId = this.current_path;
      this.$store.dispatch('downloadFavouritePath', this.doc).then(function (resp) {
        // It is necessary to create a new blob object with mime-type explicitly set
        // otherwise only Chrome works like it should
        // var newBlob = new Blob([resp.body], {type: 'application/pdf'});
        // var newBlob = new Blob([resp.body]);
        //
        // // IE doesn't allow using a blob object directly as link href
        // // instead it is necessary to use msSaveOrOpenBlob
        // if (window.navigator && window.navigator.msSaveOrOpenBlob) {
        //     window.navigator.msSaveOrOpenBlob(newBlob);
        //     return
        // }
        // For other browsers:
        // Create a link pointing to the ObjectURL containing the blob.
        // const data = window.URL.createObjectURL(newBlob);
        var link = document.createElement('a');
        link.href = resp.data.url; // link.target = "_blank";

        link.download = 'favourites.xlsx';
        link.click(); // setTimeout(function () {
        //     // For Firefox it is necessary to delay revoking the ObjectURL
        //     window.URL.revokeObjectURL(data)
        // }, 100);

        _this3.$store.commit('closeModal', '#fieldsToDocumentModal');
      })["finally"](function () {
        _this3.loading = false;
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Favourites/AddPathModal.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Favourites/AddPathModal.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: "AddPathModal",
  data: function data() {
    return {
      loading: false,
      path: {
        name: '',
        color: 'yellow',
        lotCount: 0
      }
    };
  },
  methods: {
    cancel: function cancel() {
      this.$store.commit('closeModal', '#addPathModal');
      this.path = {
        name: '',
        color: 'yellow'
      };
    },
    save: function save() {
      var _this = this;

      this.$store.dispatch('saveFavouritePath', this.path).then(function (resp) {
        _this.$store.commit('closeModal', '#addPathModal');
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Favourites/EditPathModal.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Favourites/EditPathModal.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: "EditPathModal",
  data: function data() {
    return {
      loading: false,
      path: {
        name: '',
        pathId: 0,
        color: ''
      },
      template: {
        name: '',
        pathId: 0,
        color: 'yellow'
      }
    };
  },
  computed: {
    current_path: function current_path() {
      return this.$store.getters.current_path;
    },
    paths: function paths() {
      return this.$store.getters.favourites_paths;
    },
    edit_path: {
      get: function get() {
        var _this = this;

        var index = this.paths.findIndex(function (item) {
          return item.pathId === _this.current_path;
        });

        if (index >= 0) {
          return JSON.parse(JSON.stringify(this.paths[index]));
        } else {
          return JSON.parse(JSON.stringify(this.template));
        }
      },
      set: function set(value) {
        this.path = value;
      }
    }
  },
  methods: {
    cancel: function cancel() {
      this.$store.commit('closeModal', '#editPathModal');
    },
    save: function save() {
      var _this2 = this;

      this.$store.dispatch('saveFavouritePath', this.edit_path).then(function (resp) {
        _this2.$store.commit('closeModal', '#editPathModal');
      });
    }
  }
});

/***/ }),

/***/ "./resources/js/pages/Favourites.vue":
/*!*******************************************!*\
  !*** ./resources/js/pages/Favourites.vue ***!
  \*******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Favourites_vue_vue_type_template_id_d8887b9a_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Favourites.vue?vue&type=template&id=d8887b9a&scoped=true& */ "./resources/js/pages/Favourites.vue?vue&type=template&id=d8887b9a&scoped=true&");
/* harmony import */ var _Favourites_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Favourites.vue?vue&type=script&lang=js& */ "./resources/js/pages/Favourites.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Favourites_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Favourites_vue_vue_type_template_id_d8887b9a_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _Favourites_vue_vue_type_template_id_d8887b9a_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "d8887b9a",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/pages/Favourites.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/pages/Favourites/AddFieldsToDocument.vue":
/*!***************************************************************!*\
  !*** ./resources/js/pages/Favourites/AddFieldsToDocument.vue ***!
  \***************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _AddFieldsToDocument_vue_vue_type_template_id_7368ec94_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./AddFieldsToDocument.vue?vue&type=template&id=7368ec94&scoped=true& */ "./resources/js/pages/Favourites/AddFieldsToDocument.vue?vue&type=template&id=7368ec94&scoped=true&");
/* harmony import */ var _AddFieldsToDocument_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./AddFieldsToDocument.vue?vue&type=script&lang=js& */ "./resources/js/pages/Favourites/AddFieldsToDocument.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _AddFieldsToDocument_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _AddFieldsToDocument_vue_vue_type_template_id_7368ec94_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _AddFieldsToDocument_vue_vue_type_template_id_7368ec94_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "7368ec94",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/pages/Favourites/AddFieldsToDocument.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/pages/Favourites/AddPathModal.vue":
/*!********************************************************!*\
  !*** ./resources/js/pages/Favourites/AddPathModal.vue ***!
  \********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _AddPathModal_vue_vue_type_template_id_e8d7d8da_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./AddPathModal.vue?vue&type=template&id=e8d7d8da&scoped=true& */ "./resources/js/pages/Favourites/AddPathModal.vue?vue&type=template&id=e8d7d8da&scoped=true&");
/* harmony import */ var _AddPathModal_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./AddPathModal.vue?vue&type=script&lang=js& */ "./resources/js/pages/Favourites/AddPathModal.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _AddPathModal_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _AddPathModal_vue_vue_type_template_id_e8d7d8da_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _AddPathModal_vue_vue_type_template_id_e8d7d8da_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "e8d7d8da",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/pages/Favourites/AddPathModal.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/pages/Favourites/EditPathModal.vue":
/*!*********************************************************!*\
  !*** ./resources/js/pages/Favourites/EditPathModal.vue ***!
  \*********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _EditPathModal_vue_vue_type_template_id_58706e22_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./EditPathModal.vue?vue&type=template&id=58706e22&scoped=true& */ "./resources/js/pages/Favourites/EditPathModal.vue?vue&type=template&id=58706e22&scoped=true&");
/* harmony import */ var _EditPathModal_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./EditPathModal.vue?vue&type=script&lang=js& */ "./resources/js/pages/Favourites/EditPathModal.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _EditPathModal_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _EditPathModal_vue_vue_type_template_id_58706e22_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _EditPathModal_vue_vue_type_template_id_58706e22_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "58706e22",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/pages/Favourites/EditPathModal.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/pages/Favourites.vue?vue&type=script&lang=js&":
/*!********************************************************************!*\
  !*** ./resources/js/pages/Favourites.vue?vue&type=script&lang=js& ***!
  \********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Favourites_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Favourites.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Favourites.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Favourites_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/pages/Favourites/AddFieldsToDocument.vue?vue&type=script&lang=js&":
/*!****************************************************************************************!*\
  !*** ./resources/js/pages/Favourites/AddFieldsToDocument.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_AddFieldsToDocument_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./AddFieldsToDocument.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Favourites/AddFieldsToDocument.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_AddFieldsToDocument_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/pages/Favourites/AddPathModal.vue?vue&type=script&lang=js&":
/*!*********************************************************************************!*\
  !*** ./resources/js/pages/Favourites/AddPathModal.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_AddPathModal_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./AddPathModal.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Favourites/AddPathModal.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_AddPathModal_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/pages/Favourites/EditPathModal.vue?vue&type=script&lang=js&":
/*!**********************************************************************************!*\
  !*** ./resources/js/pages/Favourites/EditPathModal.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_EditPathModal_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./EditPathModal.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Favourites/EditPathModal.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_EditPathModal_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/pages/Favourites.vue?vue&type=template&id=d8887b9a&scoped=true&":
/*!**************************************************************************************!*\
  !*** ./resources/js/pages/Favourites.vue?vue&type=template&id=d8887b9a&scoped=true& ***!
  \**************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Favourites_vue_vue_type_template_id_d8887b9a_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Favourites_vue_vue_type_template_id_d8887b9a_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Favourites_vue_vue_type_template_id_d8887b9a_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Favourites.vue?vue&type=template&id=d8887b9a&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Favourites.vue?vue&type=template&id=d8887b9a&scoped=true&");


/***/ }),

/***/ "./resources/js/pages/Favourites/AddFieldsToDocument.vue?vue&type=template&id=7368ec94&scoped=true&":
/*!**********************************************************************************************************!*\
  !*** ./resources/js/pages/Favourites/AddFieldsToDocument.vue?vue&type=template&id=7368ec94&scoped=true& ***!
  \**********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_AddFieldsToDocument_vue_vue_type_template_id_7368ec94_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_AddFieldsToDocument_vue_vue_type_template_id_7368ec94_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_AddFieldsToDocument_vue_vue_type_template_id_7368ec94_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./AddFieldsToDocument.vue?vue&type=template&id=7368ec94&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Favourites/AddFieldsToDocument.vue?vue&type=template&id=7368ec94&scoped=true&");


/***/ }),

/***/ "./resources/js/pages/Favourites/AddPathModal.vue?vue&type=template&id=e8d7d8da&scoped=true&":
/*!***************************************************************************************************!*\
  !*** ./resources/js/pages/Favourites/AddPathModal.vue?vue&type=template&id=e8d7d8da&scoped=true& ***!
  \***************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_AddPathModal_vue_vue_type_template_id_e8d7d8da_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_AddPathModal_vue_vue_type_template_id_e8d7d8da_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_AddPathModal_vue_vue_type_template_id_e8d7d8da_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./AddPathModal.vue?vue&type=template&id=e8d7d8da&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Favourites/AddPathModal.vue?vue&type=template&id=e8d7d8da&scoped=true&");


/***/ }),

/***/ "./resources/js/pages/Favourites/EditPathModal.vue?vue&type=template&id=58706e22&scoped=true&":
/*!****************************************************************************************************!*\
  !*** ./resources/js/pages/Favourites/EditPathModal.vue?vue&type=template&id=58706e22&scoped=true& ***!
  \****************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_EditPathModal_vue_vue_type_template_id_58706e22_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_EditPathModal_vue_vue_type_template_id_58706e22_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_EditPathModal_vue_vue_type_template_id_58706e22_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./EditPathModal.vue?vue&type=template&id=58706e22&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Favourites/EditPathModal.vue?vue&type=template&id=58706e22&scoped=true&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Favourites.vue?vue&type=template&id=d8887b9a&scoped=true&":
/*!*****************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Favourites.vue?vue&type=template&id=d8887b9a&scoped=true& ***!
  \*****************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render),
/* harmony export */   "staticRenderFns": () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function () {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    { staticClass: "container bkt-page bkt-container" },
    [
      _c("h1", { staticClass: "bkt-page__title" }, [_vm._v("Избранное")]),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "bkt-favourites" },
        [
          _c(
            "div",
            {
              staticClass:
                "bkt-favourites__filters bkt-wrapper-column bkt-wrapper-down-md-column-reverse",
            },
            [
              _c(
                "div",
                {
                  staticClass:
                    "bkt-favourites__filters-inner bkt-nowrap bkt-wrapper-between bkt-wrapper-down-md bkt-gap",
                },
                [
                  _c(
                    "div",
                    {
                      staticClass:
                        "d-flex bkt-wrapper-down-md-between bkt-w-md-100 bkt-gap-small bkt-gap-down-sm-mini",
                    },
                    [
                      _c(
                        "button",
                        {
                          staticClass:
                            "bkt-button-icon bkt-favourites__filters-action d-none d-md-block",
                          class: _vm.search_mode
                            ? "bkt-bg-primary shadow"
                            : "bkt-bg-white",
                          on: {
                            click: function ($event) {
                              _vm.search_mode = !_vm.search_mode
                            },
                          },
                        },
                        [
                          _c("bkt-icon", {
                            staticClass: "bkt-button__icon",
                            attrs: {
                              name: "Search",
                              color: _vm.search_mode ? "white" : "primary",
                            },
                          }),
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _c(
                        "button",
                        {
                          staticClass:
                            "bkt-button bkt-favourites__filters-action",
                          attrs: {
                            "data-bs-toggle": "modal",
                            "data-bs-target": "#addPathModal",
                            disabled: _vm.loading,
                          },
                        },
                        [
                          _c(
                            "span",
                            [
                              _c("bkt-icon", {
                                attrs: {
                                  name: "FolderAdd",
                                  color: "green",
                                  width: "16px",
                                  height: "16px",
                                },
                              }),
                            ],
                            1
                          ),
                          _vm._v(" "),
                          _c("span", { staticClass: "d-none d-xl-block" }, [
                            _vm._v("Создать папку"),
                          ]),
                        ]
                      ),
                      _vm._v(" "),
                      _c(
                        "button",
                        {
                          staticClass:
                            "bkt-button bkt-favourites__filters-action",
                          attrs: {
                            disabled: _vm.loading,
                            "data-bs-toggle": "modal",
                            "data-bs-target": "#fieldsToDocumentModal",
                          },
                        },
                        [
                          _c(
                            "span",
                            [
                              _c("bkt-icon", {
                                attrs: {
                                  name: "Download",
                                  color: "yellow",
                                  width: "16px",
                                  height: "16px",
                                },
                              }),
                            ],
                            1
                          ),
                          _vm._v(" "),
                          _c("span", { staticClass: "d-none d-xl-block" }, [
                            _vm._v("Скачать"),
                          ]),
                        ]
                      ),
                      _vm._v(" "),
                      _c(
                        "button",
                        {
                          staticClass:
                            "bkt-button bkt-favourites__filters-action",
                          attrs: {
                            "data-bs-toggle": "modal",
                            "data-bs-target": "#editPathModal",
                            disabled: _vm.loading,
                          },
                        },
                        [
                          _c(
                            "span",
                            [
                              _c("bkt-icon", {
                                attrs: {
                                  name: "Settings",
                                  color: "pink",
                                  width: "16px",
                                  height: "16px",
                                },
                              }),
                            ],
                            1
                          ),
                          _vm._v(" "),
                          _c("span", { staticClass: "d-none d-xl-block" }, [
                            _vm._v("Редактировать"),
                          ]),
                        ]
                      ),
                      _vm._v(" "),
                      _c(
                        "button",
                        {
                          staticClass:
                            "bkt-button bkt-favourites__filters-action",
                          attrs: { disabled: _vm.loading },
                          on: { click: _vm.removeFavouritePath },
                        },
                        [
                          _c(
                            "span",
                            [
                              _c("bkt-icon", {
                                attrs: {
                                  name: "FolderDelete",
                                  color: "red",
                                  width: "16px",
                                  height: "16px",
                                },
                              }),
                            ],
                            1
                          ),
                          _vm._v(" "),
                          _c("span", { staticClass: "d-none d-xl-block" }, [
                            _vm._v("Удалить"),
                          ]),
                        ]
                      ),
                    ]
                  ),
                  _vm._v(" "),
                  _c("bkt-select", {
                    staticClass: "d-none d-md-block",
                    attrs: {
                      select_class: "bkt-v-select_material w-100 main",
                      name: "sort",
                      subtitle: "сгруппировать",
                      reduce: function (item) {
                        return item.value
                      },
                      option_label: "title",
                      options: _vm.to_group,
                      clearable: false,
                    },
                    model: {
                      value: _vm.group,
                      callback: function ($$v) {
                        _vm.group = $$v
                      },
                      expression: "group",
                    },
                  }),
                ],
                1
              ),
              _vm._v(" "),
              _vm.search_mode
                ? _c(
                    "div",
                    {
                      staticClass:
                        "bkt-favourites__filters-card bkt-wrapper-column bkt-gap-large",
                    },
                    [
                      _c("div", { staticClass: "bkt-menu__search" }, [
                        _c(
                          "div",
                          { staticClass: "bkt-search position-relative" },
                          [
                            _c("input", {
                              staticClass:
                                "w-100 bkt-search__input d-md-block d-none",
                              attrs: {
                                type: "text",
                                placeholder: "Введите нужное слово или фразу",
                              },
                            }),
                            _vm._v(" "),
                            _c("input", {
                              staticClass:
                                "w-100 bkt-search__input d-md-none d-block",
                              attrs: { type: "text", placeholder: "Поиск..." },
                            }),
                            _vm._v(" "),
                            _c(
                              "button",
                              {
                                staticClass:
                                  "bkt-button green bkt-search__button",
                              },
                              [
                                _c(
                                  "span",
                                  { staticClass: "d-none d-md-block" },
                                  [_vm._v("Найти")]
                                ),
                                _vm._v(" "),
                                _c("bkt-icon", {
                                  staticClass: "d-block d-md-none",
                                  attrs: { name: "Search" },
                                }),
                              ],
                              1
                            ),
                          ]
                        ),
                      ]),
                      _vm._v(" "),
                      _vm._m(0),
                    ]
                  )
                : _vm._e(),
              _vm._v(" "),
              _c(
                "div",
                {
                  staticClass:
                    "bkt-wrapper-between bkt-nowrap d-md-none bkt-gap",
                },
                [
                  _c(
                    "button",
                    {
                      staticClass: "bkt-button-icon",
                      class: _vm.search_mode
                        ? "bkt-bg-primary shadow"
                        : "bkt-bg-white",
                      on: {
                        click: function ($event) {
                          _vm.search_mode = !_vm.search_mode
                        },
                      },
                    },
                    [
                      _c("bkt-icon", {
                        staticClass: "bkt-button__icon",
                        attrs: {
                          name: "Search",
                          color: _vm.search_mode ? "white" : "primary",
                        },
                      }),
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c("bkt-select", {
                    staticClass: "w-100",
                    attrs: {
                      select_class: "bkt-v-select_material w-100 main",
                      name: "sort",
                      subtitle: "сгруппировать",
                      reduce: function (item) {
                        return item.value
                      },
                      option_label: "title",
                      options: _vm.to_group,
                      clearable: false,
                    },
                    model: {
                      value: _vm.group,
                      callback: function ($$v) {
                        _vm.group = $$v
                      },
                      expression: "group",
                    },
                  }),
                ],
                1
              ),
            ]
          ),
          _vm._v(" "),
          _c("div", { staticClass: "bkt-favourites__paths-list" }, [
            _c(
              "div",
              { staticClass: "d-md-block d-none" },
              [
                _vm.items_paths.length > 0
                  ? _c(
                      "slick",
                      _vm._b(
                        {
                          scopedSlots: _vm._u(
                            [
                              {
                                key: "prevArrow",
                                fn: function (arrowOption) {
                                  return [
                                    _c(
                                      "svg",
                                      {
                                        attrs: {
                                          width: "8",
                                          height: "12",
                                          viewBox: "0 0 8 12",
                                          fill: "#ffc515",
                                        },
                                      },
                                      [
                                        _c("path", {
                                          attrs: {
                                            d: "M8 1.42L3.42 6L8 10.59L6.59 12L0.59 6L6.59 1.23266e-07L8 1.42Z",
                                          },
                                        }),
                                      ]
                                    ),
                                  ]
                                },
                              },
                              {
                                key: "nextArrow",
                                fn: function (arrowOption) {
                                  return [
                                    _c(
                                      "svg",
                                      {
                                        attrs: {
                                          fill: "#ffc515",
                                          width: "8",
                                          height: "12",
                                          viewBox: "0 0 8 12",
                                        },
                                      },
                                      [
                                        _c("path", {
                                          attrs: {
                                            d: "M0 10.5801L4.58 6.00012L0 1.41012L1.41 0.00012207L7.41 6.00012L1.41 12.0001L0 10.5801Z",
                                          },
                                        }),
                                      ]
                                    ),
                                  ]
                                },
                              },
                            ],
                            null,
                            false,
                            3169023083
                          ),
                        },
                        "slick",
                        _vm.settings,
                        false
                      ),
                      _vm._l(_vm.items_paths, function (path, index) {
                        return _c("div", { key: index }, [
                          _c(
                            "button",
                            {
                              staticClass:
                                "bkt-button bkt-favourites__path bkt-button_plump text-uppercase",
                              class: [
                                _vm.current_path === path.pathId && path.color
                                  ? "bkt-bg-" + path.color
                                  : "",
                                {
                                  "bkt-bg-primary":
                                    _vm.current_path === path.pathId &&
                                    !path.color,
                                  "bkt-bg-white bkt-text-main":
                                    _vm.current_path !== path.pathId,
                                },
                              ],
                              on: {
                                click: function ($event) {
                                  return _vm.setCurrentPath(path.pathId)
                                },
                              },
                            },
                            [
                              _vm._v(
                                "\n                            " +
                                  _vm._s(path.name) +
                                  "\n                            "
                              ),
                              _c(
                                "span",
                                {
                                  staticClass: "bkt-badge",
                                  class: [
                                    path.color
                                      ? "bkt-text-" + path.color
                                      : "bkt-text-primary",
                                    _vm.current_path !== path.pathId &&
                                    path.color
                                      ? "bkt-bg-" + path.color + "-lighter"
                                      : "",
                                    {
                                      "bkt-bg-white":
                                        _vm.current_path === path.pathId,
                                      "bkt-bg-primary-lighter":
                                        _vm.current_path !== path.pathId &&
                                        !path.color,
                                    },
                                  ],
                                },
                                [
                                  _vm._v(
                                    "\n                                " +
                                      _vm._s(
                                        path.lotCount ? path.lotCount : "0"
                                      ) +
                                      "\n                            "
                                  ),
                                ]
                              ),
                            ]
                          ),
                        ])
                      }),
                      0
                    )
                  : _vm._e(),
              ],
              1
            ),
            _vm._v(" "),
            _c(
              "div",
              { staticClass: "d-block d-md-none" },
              [
                _c("bkt-collapse", {
                  attrs: {
                    id: "collapsePaths",
                    main_class: "bkt-favourites__path-collapse",
                    header_class: _vm.current_path_object.color
                      ? "bkt-bg-" + _vm.current_path_object.color
                      : "bkt-bg-primary",
                    collapse_button_class:
                      _vm.items_paths.length > 1 ? "bkt-bg-white" : "d-none",
                  },
                  scopedSlots: _vm._u(
                    [
                      _vm.items_paths.length > 0
                        ? {
                            key: "title",
                            fn: function () {
                              return [
                                _c("h6", { staticClass: "mx-auto" }, [
                                  _vm._v(
                                    "\n                            " +
                                      _vm._s(_vm.current_path_object.name) +
                                      "\n                            "
                                  ),
                                  _c(
                                    "span",
                                    {
                                      staticClass: "bkt-badge bkt-bg-white",
                                      class: _vm.current_path_object.color
                                        ? "bkt-text-" +
                                          _vm.current_path_object.color
                                        : "bkt-text-primary",
                                    },
                                    [
                                      _vm._v(
                                        "\n                                " +
                                          _vm._s(
                                            _vm.current_path_object.lotCount
                                              ? _vm.current_path_object.lotCount
                                              : "0"
                                          ) +
                                          "\n                            "
                                      ),
                                    ]
                                  ),
                                ]),
                              ]
                            },
                            proxy: true,
                          }
                        : null,
                      _vm.items_paths.length > 0
                        ? {
                            key: "collapse",
                            fn: function () {
                              return [
                                _c(
                                  "div",
                                  { staticClass: "bkt-wrapper-column bkt-gap" },
                                  _vm._l(
                                    _vm.items_paths,
                                    function (path, index) {
                                      return path.pathId !== _vm.current_path
                                        ? _c(
                                            "button",
                                            {
                                              key: index,
                                              staticClass:
                                                "w-100 bkt-button bkt-button_plump text-uppercase bkt-bg-white bkt-text-main text-center",
                                              on: {
                                                click: function ($event) {
                                                  return _vm.setCurrentPath(
                                                    path.pathId
                                                  )
                                                },
                                              },
                                            },
                                            [
                                              _vm._v(
                                                "\n                                " +
                                                  _vm._s(path.name) +
                                                  "\n                                "
                                              ),
                                              _c(
                                                "span",
                                                {
                                                  staticClass: "bkt-badge",
                                                  class: path.color
                                                    ? "bkt-bg-" +
                                                      path.color +
                                                      "-lighter bkt-text-" +
                                                      path.color
                                                    : "bkt-text-primary bkt-bg-primary-lighter",
                                                },
                                                [
                                                  _vm._v(
                                                    "\n                                " +
                                                      _vm._s(
                                                        path.lotCount
                                                          ? path.lotCount
                                                          : "0"
                                                      ) +
                                                      "\n                            "
                                                  ),
                                                ]
                                              ),
                                            ]
                                          )
                                        : _vm._e()
                                    }
                                  ),
                                  0
                                ),
                              ]
                            },
                            proxy: true,
                          }
                        : null,
                    ],
                    null,
                    true
                  ),
                }),
              ],
              1
            ),
          ]),
          _vm._v(" "),
          _c("bkt-card-list", {
            attrs: {
              current_component: "BktCard",
              items: _vm.items,
              loading: _vm.loading,
              pagination_data: _vm.pagination_data,
              infinite: "",
              method_name: "getFavourites",
              method_params: _vm.method_params,
            },
            on: { "change-page": _vm.getData },
          }),
        ],
        1
      ),
      _vm._v(" "),
      _c("bkt-add-path-modal"),
      _vm._v(" "),
      _c("bkt-edit-path-modal"),
      _vm._v(" "),
      _c("bkt-excel-modal"),
    ],
    1
  )
}
var staticRenderFns = [
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "bkt-menu__group-fields" }, [
      _c("div", { staticClass: "bkt-form" }, [
        _c("div", { staticClass: "col-12 col-md-3" }, [
          _c("div", { staticClass: "bkt-select__wrapper text-left" }, [
            _c(
              "label",
              { staticClass: "bkt-select__label", attrs: { for: "group" } },
              [_vm._v("группа")]
            ),
            _vm._v(" "),
            _c(
              "select",
              { staticClass: "bkt-select", attrs: { id: "group" } },
              [
                _c("option", { attrs: { selected: "", value: "" } }, [
                  _vm._v("Текущая"),
                ]),
                _vm._v(" "),
                _c("option", [_vm._v("One")]),
                _vm._v(" "),
                _c("option", [_vm._v("Two")]),
              ]
            ),
          ]),
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "col-12 col-md-3" }, [
          _c("div", { staticClass: "bkt-select__wrapper text-left" }, [
            _c(
              "label",
              { staticClass: "bkt-select__label", attrs: { for: "label" } },
              [_vm._v("метка")]
            ),
            _vm._v(" "),
            _c(
              "select",
              { staticClass: "bkt-select", attrs: { id: "label" } },
              [
                _c("option", { attrs: { selected: "", value: "" } }, [
                  _vm._v("Метка 1"),
                ]),
                _vm._v(" "),
                _c("option", [_vm._v("One")]),
                _vm._v(" "),
                _c("option", [_vm._v("Two")]),
              ]
            ),
          ]),
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "col-12 col-md-6" }, [
          _c(
            "div",
            { staticClass: "bkt-select__wrapper text-left bkt-sort-by" },
            [
              _c(
                "label",
                { staticClass: "bkt-select__label", attrs: { for: "sort" } },
                [_vm._v("сортировать по")]
              ),
              _vm._v(" "),
              _c(
                "select",
                { staticClass: "bkt-select", attrs: { id: "sort" } },
                [
                  _c("option", { attrs: { selected: "", value: "" } }, [
                    _vm._v("Добавлению в избранное"),
                  ]),
                  _vm._v(" "),
                  _c("option", [_vm._v("One")]),
                  _vm._v(" "),
                  _c("option", [_vm._v("Two")]),
                ]
              ),
            ]
          ),
        ]),
      ]),
    ])
  },
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Favourites/AddFieldsToDocument.vue?vue&type=template&id=7368ec94&scoped=true&":
/*!*************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Favourites/AddFieldsToDocument.vue?vue&type=template&id=7368ec94&scoped=true& ***!
  \*************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render),
/* harmony export */   "staticRenderFns": () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function () {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("bkt-modal", {
    ref: "fieldsToDocumentModal",
    attrs: {
      id: "fieldsToDocumentModal",
      modal_class: "bkt-fields-document-modal",
      title: "Какие поля добавить в документ? (Excel)",
      loading: _vm.loading,
      right_button: "Скачать",
      right_action: _vm.download,
      right_button_class:
        "bkt-button bkt-bg-primary bkt-modal-save bkt-button_plump",
    },
    scopedSlots: _vm._u([
      {
        key: "left_button",
        fn: function () {
          return [_c("span")]
        },
        proxy: true,
      },
      {
        key: "body",
        fn: function (ref) {
          var invalid = ref.invalid
          return [
            _c("div", { staticClass: "text-left" }, [
              _c("div", { staticClass: "bkt-fields-actions" }, [
                _c(
                  "span",
                  {
                    staticClass: "bkt-fields-action bkt-text-red me-2",
                    on: { click: _vm.removeAllFields },
                  },
                  [_vm._v("Выключить все")]
                ),
                _vm._v(" "),
                _c(
                  "span",
                  {
                    staticClass: "bkt-fields-action bkt-text-green",
                    on: { click: _vm.selectAllFields },
                  },
                  [_vm._v("Включить все")]
                ),
              ]),
              _vm._v(" "),
              _c(
                "div",
                { staticClass: "row" },
                _vm._l(_vm.fields, function (field, index) {
                  return _c(
                    "div",
                    { staticClass: "col-12 col-md-6" },
                    [
                      _c("bkt-checkbox", {
                        attrs: { label: field.title, name: "field-" + index },
                        model: {
                          value: _vm.doc[field.code],
                          callback: function ($$v) {
                            _vm.$set(_vm.doc, field.code, $$v)
                          },
                          expression: "doc[field.code]",
                        },
                      }),
                    ],
                    1
                  )
                }),
                0
              ),
            ]),
          ]
        },
      },
    ]),
  })
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Favourites/AddPathModal.vue?vue&type=template&id=e8d7d8da&scoped=true&":
/*!******************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Favourites/AddPathModal.vue?vue&type=template&id=e8d7d8da&scoped=true& ***!
  \******************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render),
/* harmony export */   "staticRenderFns": () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function () {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("bkt-modal", {
    ref: "addPathModal",
    attrs: {
      id: "addPathModal",
      modal_class: "bkt-folder-modal",
      title: "Создать папку",
      loading: _vm.loading,
    },
    on: { left_action: _vm.cancel, right_action: _vm.save },
    scopedSlots: _vm._u([
      {
        key: "body",
        fn: function (ref) {
          var invalid = ref.invalid
          return [
            _c(
              "div",
              { staticClass: "bkt-wrapper-column bkt-gap-large" },
              [
                _c("bkt-input", {
                  attrs: {
                    rules: "required",
                    name: "name_folder",
                    placeholder: "Введите название папки",
                    label: "название папки",
                    no_group_item: "",
                  },
                  model: {
                    value: _vm.path.name,
                    callback: function ($$v) {
                      _vm.$set(_vm.path, "name", $$v)
                    },
                    expression: "path.name",
                  },
                }),
                _vm._v(" "),
                _c(
                  "div",
                  { staticClass: "bkt-wrapper mx-0" },
                  [
                    _c("bkt-checkbox", {
                      staticClass: "bkt-check_color",
                      attrs: {
                        val: "yellow",
                        name: "yellow",
                        type: "radio",
                        check_color: "yellow",
                        border_color:
                          _vm.path.color === "yellow" ? "yellow" : "",
                      },
                      model: {
                        value: _vm.path.color,
                        callback: function ($$v) {
                          _vm.$set(_vm.path, "color", $$v)
                        },
                        expression: "path.color",
                      },
                    }),
                    _vm._v(" "),
                    _c("bkt-checkbox", {
                      staticClass: "bkt-check_color",
                      attrs: {
                        val: "blue",
                        name: "blue",
                        type: "radio",
                        check_color: "blue",
                        border_color: _vm.path.color === "blue" ? "blue" : "",
                      },
                      model: {
                        value: _vm.path.color,
                        callback: function ($$v) {
                          _vm.$set(_vm.path, "color", $$v)
                        },
                        expression: "path.color",
                      },
                    }),
                    _vm._v(" "),
                    _c("bkt-checkbox", {
                      staticClass: "bkt-check_color",
                      attrs: {
                        val: "pink",
                        name: "pink",
                        type: "radio",
                        check_color: "pink",
                        border_color: _vm.path.color === "pink" ? "pink" : "",
                      },
                      model: {
                        value: _vm.path.color,
                        callback: function ($$v) {
                          _vm.$set(_vm.path, "color", $$v)
                        },
                        expression: "path.color",
                      },
                    }),
                    _vm._v(" "),
                    _c("bkt-checkbox", {
                      staticClass: "bkt-check_color",
                      attrs: {
                        val: "green",
                        name: "green",
                        type: "radio",
                        check_color: "green",
                        border_color: _vm.path.color === "green" ? "green" : "",
                      },
                      model: {
                        value: _vm.path.color,
                        callback: function ($$v) {
                          _vm.$set(_vm.path, "color", $$v)
                        },
                        expression: "path.color",
                      },
                    }),
                    _vm._v(" "),
                    _c("bkt-checkbox", {
                      staticClass: "bkt-check_color",
                      attrs: {
                        val: "red",
                        name: "red",
                        type: "radio",
                        check_color: "red",
                        border_color: _vm.path.color === "red" ? "red" : "",
                      },
                      model: {
                        value: _vm.path.color,
                        callback: function ($$v) {
                          _vm.$set(_vm.path, "color", $$v)
                        },
                        expression: "path.color",
                      },
                    }),
                    _vm._v(" "),
                    _c("bkt-checkbox", {
                      staticClass: "bkt-check_color",
                      attrs: {
                        val: "main",
                        name: "main",
                        type: "radio",
                        check_color: "main",
                        border_color: _vm.path.color === "main" ? "main" : "",
                      },
                      model: {
                        value: _vm.path.color,
                        callback: function ($$v) {
                          _vm.$set(_vm.path, "color", $$v)
                        },
                        expression: "path.color",
                      },
                    }),
                    _vm._v(" "),
                    _c("bkt-checkbox", {
                      staticClass: "bkt-check_color",
                      attrs: {
                        val: "primary",
                        name: "primary",
                        type: "radio",
                        check_color: "primary",
                        border_color:
                          _vm.path.color === "primary" ? "primary" : "",
                      },
                      model: {
                        value: _vm.path.color,
                        callback: function ($$v) {
                          _vm.$set(_vm.path, "color", $$v)
                        },
                        expression: "path.color",
                      },
                    }),
                  ],
                  1
                ),
              ],
              1
            ),
          ]
        },
      },
    ]),
  })
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Favourites/EditPathModal.vue?vue&type=template&id=58706e22&scoped=true&":
/*!*******************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Favourites/EditPathModal.vue?vue&type=template&id=58706e22&scoped=true& ***!
  \*******************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render),
/* harmony export */   "staticRenderFns": () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function () {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("bkt-modal", {
    ref: "addPathModal",
    attrs: {
      id: "editPathModal",
      modal_class: "bkt-folder-modal",
      title:
        "Редактировать папку <span class='text-uppercase bkt-text-primary'>" +
        _vm.edit_path.name +
        "</span>",
      loading: _vm.loading,
    },
    on: { left_action: _vm.cancel, right_action: _vm.save },
    scopedSlots: _vm._u([
      {
        key: "body",
        fn: function (ref) {
          var invalid = ref.invalid
          return [
            _c(
              "div",
              { staticClass: "bkt-wrapper-column bkt-gap-large" },
              [
                _c("bkt-input", {
                  attrs: {
                    rules: "required",
                    name: "edit_name_folder",
                    placeholder: "Введите название папки",
                    label: "название папки",
                    no_group_item: "",
                  },
                  model: {
                    value: _vm.edit_path.name,
                    callback: function ($$v) {
                      _vm.$set(_vm.edit_path, "name", $$v)
                    },
                    expression: "edit_path.name",
                  },
                }),
                _vm._v(" "),
                _c(
                  "div",
                  { staticClass: "bkt-wrapper mx-0" },
                  [
                    _c("bkt-checkbox", {
                      staticClass: "bkt-check_color",
                      attrs: {
                        val: "yellow",
                        name: "edit-yellow",
                        type: "radio",
                        rules: "required",
                        check_color: "yellow",
                        border_color:
                          _vm.edit_path.color === "yellow" ? "yellow" : "",
                      },
                      model: {
                        value: _vm.edit_path.color,
                        callback: function ($$v) {
                          _vm.$set(_vm.edit_path, "color", $$v)
                        },
                        expression: "edit_path.color",
                      },
                    }),
                    _vm._v(" "),
                    _c("bkt-checkbox", {
                      staticClass: "bkt-check_color",
                      attrs: {
                        val: "blue",
                        name: "edit-blue",
                        type: "radio",
                        check_color: "blue",
                        border_color:
                          _vm.edit_path.color === "blue" ? "blue" : "",
                      },
                      model: {
                        value: _vm.edit_path.color,
                        callback: function ($$v) {
                          _vm.$set(_vm.edit_path, "color", $$v)
                        },
                        expression: "edit_path.color",
                      },
                    }),
                    _vm._v(" "),
                    _c("bkt-checkbox", {
                      staticClass: "bkt-check_color",
                      attrs: {
                        val: "pink",
                        name: "edit-pink",
                        type: "radio",
                        check_color: "pink",
                        border_color:
                          _vm.edit_path.color === "pink" ? "pink" : "",
                      },
                      model: {
                        value: _vm.edit_path.color,
                        callback: function ($$v) {
                          _vm.$set(_vm.edit_path, "color", $$v)
                        },
                        expression: "edit_path.color",
                      },
                    }),
                    _vm._v(" "),
                    _c("bkt-checkbox", {
                      staticClass: "bkt-check_color",
                      attrs: {
                        val: "green",
                        name: "edit-green",
                        type: "radio",
                        check_color: "green",
                        border_color:
                          _vm.edit_path.color === "green" ? "green" : "",
                      },
                      model: {
                        value: _vm.edit_path.color,
                        callback: function ($$v) {
                          _vm.$set(_vm.edit_path, "color", $$v)
                        },
                        expression: "edit_path.color",
                      },
                    }),
                    _vm._v(" "),
                    _c("bkt-checkbox", {
                      staticClass: "bkt-check_color",
                      attrs: {
                        val: "red",
                        name: "edit-red",
                        type: "radio",
                        check_color: "red",
                        border_color:
                          _vm.edit_path.color === "red" ? "red" : "",
                      },
                      model: {
                        value: _vm.edit_path.color,
                        callback: function ($$v) {
                          _vm.$set(_vm.edit_path, "color", $$v)
                        },
                        expression: "edit_path.color",
                      },
                    }),
                    _vm._v(" "),
                    _c("bkt-checkbox", {
                      staticClass: "bkt-check_color",
                      attrs: {
                        val: "main",
                        name: "edit-main",
                        type: "radio",
                        check_color: "main",
                        border_color:
                          _vm.edit_path.color === "main" ? "main" : "",
                      },
                      model: {
                        value: _vm.edit_path.color,
                        callback: function ($$v) {
                          _vm.$set(_vm.edit_path, "color", $$v)
                        },
                        expression: "edit_path.color",
                      },
                    }),
                    _vm._v(" "),
                    _c("bkt-checkbox", {
                      staticClass: "bkt-check_color",
                      attrs: {
                        val: "primary",
                        name: "edit-primary",
                        type: "radio",
                        check_color: "primary",
                        border_color:
                          _vm.edit_path.color === "primary" ? "primary" : "",
                      },
                      model: {
                        value: _vm.edit_path.color,
                        callback: function ($$v) {
                          _vm.$set(_vm.edit_path, "color", $$v)
                        },
                        expression: "edit_path.color",
                      },
                    }),
                  ],
                  1
                ),
              ],
              1
            ),
          ]
        },
      },
    ]),
  })
}
var staticRenderFns = []
render._withStripped = true



/***/ })

}]);