"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["without-ecp"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/WithoutEcp.vue?vue&type=script&lang=js&":
/*!************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/WithoutEcp.vue?vue&type=script&lang=js& ***!
  \************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: "WithEcp",
  data: function data() {
    return {
      application: {
        email: '',
        lotId: 0,
        phone: "",
        socialsForAnswer: []
      }
    };
  },
  methods: {
    sendApplication: function sendApplication() {
      axios.post('/api/send/application', this.application).then(function (resp) {})["catch"](function (error) {});
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/WithoutEcp.vue?vue&type=template&id=07d83b0a&scoped=true&":
/*!***********************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/WithoutEcp.vue?vue&type=template&id=07d83b0a&scoped=true& ***!
  \***********************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render),
/* harmony export */   "staticRenderFns": () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function render() {
  var _vm = this,
      _c = _vm._self._c;

  return _c('div', {
    staticClass: "container bkt-promo bkt-page bkt-container"
  }, [_vm._m(0), _vm._v(" "), _c('section', [_vm._m(1), _vm._v(" "), _c('div', {
    staticClass: "bkt-form row-cols-1 row-cols-md-2 row-cols-lg-4"
  }, [_c('div', {
    staticClass: "col-12 col-md-6 col-lg-3"
  }, [_c('div', {
    staticClass: "bkt-card bkt-promo__profit-card h-100"
  }, [_c('div', {
    staticClass: "bkt-icon-frame-large bkt-bg-blue-lighter"
  }, [_c('bkt-icon', {
    staticClass: "bkt-icon-frame__item",
    attrs: {
      "name": "ClipboardList",
      "color": "blue"
    }
  })], 1), _vm._v(" "), _vm._m(2)])]), _vm._v(" "), _c('div', {
    staticClass: "col-12 col-md-6 col-lg-3"
  }, [_c('div', {
    staticClass: "bkt-card bkt-promo__profit-card h-100"
  }, [_c('div', {
    staticClass: "bkt-icon-frame-large bkt-bg-green-lighter"
  }, [_c('bkt-icon', {
    staticClass: "bkt-icon-frame__item",
    attrs: {
      "name": "Clock",
      "color": "green"
    }
  })], 1), _vm._v(" "), _vm._m(3)])]), _vm._v(" "), _c('div', {
    staticClass: "col-12 col-md-6 col-lg-3"
  }, [_c('div', {
    staticClass: "bkt-card bkt-promo__profit-card h-100"
  }, [_c('div', {
    staticClass: "bkt-icon-frame-large bkt-bg-red-lighter"
  }, [_c('bkt-icon', {
    staticClass: "bkt-icon-frame__item",
    attrs: {
      "name": "CancelCircle",
      "color": "red"
    }
  })], 1), _vm._v(" "), _vm._m(4)])]), _vm._v(" "), _c('div', {
    staticClass: "col-12 col-md-6 col-lg-3"
  }, [_c('div', {
    staticClass: "bkt-card bkt-promo__profit-card h-100"
  }, [_c('div', {
    staticClass: "bkt-icon-frame-large bkt-bg-pink-lighter"
  }, [_c('bkt-icon', {
    staticClass: "bkt-icon-frame__item",
    attrs: {
      "name": "Devices",
      "color": "pink"
    }
  })], 1), _vm._v(" "), _vm._m(5)])])])]), _vm._v(" "), _vm._m(6), _vm._v(" "), _vm._m(7), _vm._v(" "), _vm._m(8), _vm._v(" "), _vm._m(9)]);
};

var staticRenderFns = [function () {
  var _vm = this,
      _c = _vm._self._c;

  return _c('section', [_c('h1', {
    staticClass: "bkt-page__title"
  }, [_vm._v("Покупка без ЭЦП")]), _vm._v(" "), _c('div', {
    staticClass: "bkt-promo__block-wrapper"
  }, [_c('div', {
    staticClass: "bkt-promo__block bkt-promo__block_ecp"
  }, [_c('div', {
    staticClass: "bkt-promo__block-body"
  }, [_c('h1', {
    staticClass: "bkt-promo__block-title"
  }, [_vm._v("Хотите участвовать"), _c('br'), _vm._v("в торгах\n                        "), _c('span', {
    staticClass: "bkt-text-yellow"
  }, [_vm._v(" без покупки ЭЦП?")])]), _vm._v(" "), _c('h4', {
    staticClass: "bkt-promo__block-text"
  }, [_vm._v("\n                        Воспользуйтесь нашим опытом побед, чтобы избежать ошибок и сэкономить время, деньги и\n                        нервы.\n                    ")]), _vm._v(" "), _c('div', {
    staticClass: "bkt-promo__block-body-row"
  }, [_c('div', {
    staticClass: "bkt-promo__block-feature"
  }, [_c('div', {
    staticClass: "check_mark bkt-bg-pink"
  }, [_vm._v("✓")]), _vm._v(" "), _c('span', [_vm._v("ЭЦП не нужна")])]), _vm._v(" "), _c('div', {
    staticClass: "bkt-promo__block-feature"
  }, [_c('div', {
    staticClass: "check_mark bkt-bg-blue"
  }, [_vm._v("✓")]), _vm._v(" "), _c('span', [_vm._v("Аккредитация не нужна")])]), _vm._v(" "), _c('div', {
    staticClass: "bkt-promo__block-feature"
  }, [_c('div', {
    staticClass: "check_mark bkt-bg-green"
  }, [_vm._v("✓")]), _vm._v(" "), _c('span', [_vm._v("Заполнять документы не нужно")])])])]), _vm._v(" "), _c('div', {
    staticClass: "bkt-promo__block-price"
  }, [_c('h2', [_vm._v("3000 ₽")]), _vm._v(" "), _c('button', {
    staticClass: "bkt-button bkt-button_yellow bkt-button_plump"
  }, [_vm._v("Купить")])])]), _vm._v(" "), _c('div', {
    staticClass: "bkt-promo__block-shadow",
    staticStyle: {
      "background-color": "rgba(13, 110, 255, 0.4)",
      "z-index": "-1",
      "top": "-5px",
      "width": "calc(100% - 5vw)"
    }
  }), _vm._v(" "), _c('div', {
    staticClass: "bkt-promo__block-shadow",
    staticStyle: {
      "background-color": "rgba(13, 110, 255, 0.2)",
      "z-index": "-2",
      "top": "-5px",
      "width": "calc(100% - 10vw)"
    }
  })])]);
}, function () {
  var _vm = this,
      _c = _vm._self._c;

  return _c('h2', {
    staticClass: "bkt-page__subtitle"
  }, [_vm._v("\n            В каких случаях покупать ЭЦП\n            "), _c('span', {
    staticClass: "bkt-text-red"
  }, [_vm._v(" невыгодно?")])]);
}, function () {
  var _vm = this,
      _c = _vm._self._c;

  return _c('div', {
    staticClass: "bkt-promo__profit-card-body"
  }, [_c('h5', {
    staticClass: "bkt-card__title"
  }, [_vm._v("Если у вас нет постоянных задач по торгам")]), _vm._v(" "), _c('p', {
    staticClass: "bkt-card__text"
  }, [_vm._v("Стоимость ЭЦП может достигать 30 000 руб. При однократном\n                            использовании её стоимость может не окупиться.\n                        ")])]);
}, function () {
  var _vm = this,
      _c = _vm._self._c;

  return _c('div', {
    staticClass: "bkt-promo__profit-card-body"
  }, [_c('h5', {
    staticClass: "bkt-card__title"
  }, [_vm._v("Если вы ограничены по времени")]), _vm._v(" "), _c('p', {
    staticClass: "bkt-card__text"
  }, [_vm._v("\n                            Оформление ЭЦП занимает несколько дней. А на торгах счёт иногда идёт на часы.\n                        ")])]);
}, function () {
  var _vm = this,
      _c = _vm._self._c;

  return _c('div', {
    staticClass: "bkt-promo__profit-card-body"
  }, [_c('h5', {
    staticClass: "bkt-card__title"
  }, [_vm._v("Если вы не планируете участвовать в торгах профессионально")]), _vm._v(" "), _c('p', {
    staticClass: "bkt-card__text"
  }, [_vm._v("Вас заинтересовал конкретный лот и вы не хотите серьёзно вникать в\n                            процесс, но планируете\n                            извлечь максимум пользы.")])]);
}, function () {
  var _vm = this,
      _c = _vm._self._c;

  return _c('div', {
    staticClass: "bkt-promo__profit-card-body"
  }, [_c('h5', {
    staticClass: "bkt-card__title"
  }, [_vm._v("Если хотит попробовать себя в торгах, но не знаете, с чего\n                            начать")]), _vm._v(" "), _c('p', {
    staticClass: "bkt-card__text"
  }, [_vm._v("Если вы не уверены в себе, мы поможем вам советом или\n                            консультацией.")])]);
}, function () {
  var _vm = this,
      _c = _vm._self._c;

  return _c('section', [_c('h2', {
    staticClass: "bkt-page__subtitle"
  }, [_vm._v("Что делаем мы?")]), _vm._v(" "), _c('div', {
    staticClass: "bkt-form bkt-container"
  }, [_c('div', {
    staticClass: "col-12 col-md-3"
  }, [_c('div', {
    staticClass: "bkt-promo__action-card"
  }, [_c('div', {
    staticClass: "plus-wrapper"
  }, [_c('div', {
    staticClass: "plus"
  }, [_vm._v("\n                            +\n                        ")])]), _vm._v(" "), _c('h5', {
    staticClass: "bkt-card__text"
  }, [_vm._v("Проводим анализ лота")]), _vm._v(" "), _c('div', {
    staticClass: "number"
  }, [_c('span', [_vm._v("01")])])])]), _vm._v(" "), _c('div', {
    staticClass: "col-12 col-md-3"
  }, [_c('div', {
    staticClass: "bkt-promo__action-card"
  }, [_c('div', {
    staticClass: "plus-wrapper"
  }, [_c('div', {
    staticClass: "plus"
  }, [_vm._v("\n                            +\n                        ")])]), _vm._v(" "), _c('h5', {
    staticClass: "bkt-card__text"
  }, [_vm._v("Даём шаблоны документов по торгам")]), _vm._v(" "), _c('div', {
    staticClass: "number"
  }, [_c('span', [_vm._v("02")])])])]), _vm._v(" "), _c('div', {
    staticClass: "col-12 col-md-3"
  }, [_c('div', {
    staticClass: "bkt-promo__action-card"
  }, [_c('div', {
    staticClass: "plus-wrapper"
  }, [_c('div', {
    staticClass: "plus"
  }, [_vm._v("\n                            +\n                        ")])]), _vm._v(" "), _c('h5', {
    staticClass: "bkt-card__text"
  }, [_vm._v("Помогаем правильно составить заявку с гарантией допуска к торгам")]), _vm._v(" "), _c('div', {
    staticClass: "number"
  }, [_c('span', [_vm._v("03")])])])]), _vm._v(" "), _c('div', {
    staticClass: "col-12 col-md-3"
  }, [_c('div', {
    staticClass: "bkt-promo__action-card"
  }, [_c('div', {
    staticClass: "plus-wrapper"
  }, [_c('div', {
    staticClass: "plus"
  }, [_vm._v("\n                            +\n                        ")])]), _vm._v(" "), _c('h5', {
    staticClass: "bkt-card__text"
  }, [_vm._v("Контролируем оплату и возврат задатка")]), _vm._v(" "), _c('div', {
    staticClass: "number"
  }, [_c('span', [_vm._v("04")])])])])])]);
}, function () {
  var _vm = this,
      _c = _vm._self._c;

  return _c('section', [_c('h2', {
    staticClass: "bkt-page__subtitle"
  }, [_vm._v("Что от вас?")]), _vm._v(" "), _c('div', {
    staticClass: "bkt-form bkt-container pe-0 justify-content-center row-cols-1 row-cols-md-2 row-cols-lg-5"
  }, [_c('div', {
    staticClass: "col"
  }, [_c('div', {
    staticClass: "bkt-promo__todo-card-wrapper h-100"
  }, [_c('div', {
    staticClass: "bkt-card bkt-promo__todo-card h-100"
  }, [_c('div', {
    staticClass: "check-wrapper"
  }, [_c('div', {
    staticClass: "check_mark"
  }, [_vm._v("✓")])]), _vm._v(" "), _c('h5', {
    staticClass: "bkt-card__text"
  }, [_vm._v("Выбрать интересующий лот")])])])]), _vm._v(" "), _c('div', {
    staticClass: "col"
  }, [_c('div', {
    staticClass: "bkt-promo__todo-card-wrapper h-100"
  }, [_c('div', {
    staticClass: "bkt-card bkt-promo__todo-card h-100"
  }, [_c('div', {
    staticClass: "check-wrapper"
  }, [_c('div', {
    staticClass: "check_mark"
  }, [_vm._v("✓")])]), _vm._v(" "), _c('h5', {
    staticClass: "bkt-card__text"
  }, [_vm._v("Оплатить услугу")])])])]), _vm._v(" "), _c('div', {
    staticClass: "col"
  }, [_c('div', {
    staticClass: "bkt-promo__todo-card-wrapper h-100"
  }, [_c('div', {
    staticClass: "bkt-card bkt-promo__todo-card h-100"
  }, [_c('div', {
    staticClass: "check-wrapper"
  }, [_c('div', {
    staticClass: "check_mark"
  }, [_vm._v("✓")])]), _vm._v(" "), _c('h5', {
    staticClass: "bkt-card__text"
  }, [_vm._v("Заполнить шаблоны документов для участия")])])])]), _vm._v(" "), _c('div', {
    staticClass: "col"
  }, [_c('div', {
    staticClass: "bkt-promo__todo-card-wrapper h-100"
  }, [_c('div', {
    staticClass: "bkt-card bkt-promo__todo-card h-100"
  }, [_c('div', {
    staticClass: "check-wrapper"
  }, [_c('div', {
    staticClass: "check_mark"
  }, [_vm._v("✓")])]), _vm._v(" "), _c('h5', {
    staticClass: "bkt-card__text"
  }, [_vm._v("Вовремя внести задаток")])])])]), _vm._v(" "), _c('div', {
    staticClass: "col"
  }, [_c('div', {
    staticClass: "bkt-promo__todo-card-wrapper h-100"
  }, [_c('div', {
    staticClass: "bkt-card bkt-promo__todo-card h-100"
  }, [_c('div', {
    staticClass: "check-wrapper"
  }, [_c('div', {
    staticClass: "check_mark"
  }, [_vm._v("✓")])]), _vm._v(" "), _c('h5', {
    staticClass: "bkt-card__text"
  }, [_vm._v("В нужный момент внести предложение по стоимости лота")])])])])])]);
}, function () {
  var _vm = this,
      _c = _vm._self._c;

  return _c('div', {
    staticClass: "bkt-promo__block_mini"
  }, [_c('h3', {
    staticClass: "bkt-promo__block-title"
  }, [_vm._v("Попробуйте себя в торгах по банкротству "), _c('span', {
    staticClass: "bkt-text-yellow"
  }, [_vm._v("без\n            переплат!")])])]);
}, function () {
  var _vm = this,
      _c = _vm._self._c;

  return _c('section', [_c('h2', {
    staticClass: "bkt-page__subtitle"
  }, [_vm._v("Как получить услугу?")]), _vm._v(" "), _c('div', {
    staticClass: "buy_sample"
  })]);
}];


/***/ }),

/***/ "./resources/js/pages/WithoutEcp.vue":
/*!*******************************************!*\
  !*** ./resources/js/pages/WithoutEcp.vue ***!
  \*******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _WithoutEcp_vue_vue_type_template_id_07d83b0a_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./WithoutEcp.vue?vue&type=template&id=07d83b0a&scoped=true& */ "./resources/js/pages/WithoutEcp.vue?vue&type=template&id=07d83b0a&scoped=true&");
/* harmony import */ var _WithoutEcp_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./WithoutEcp.vue?vue&type=script&lang=js& */ "./resources/js/pages/WithoutEcp.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _WithoutEcp_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _WithoutEcp_vue_vue_type_template_id_07d83b0a_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _WithoutEcp_vue_vue_type_template_id_07d83b0a_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "07d83b0a",
  null
  
)

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/pages/WithoutEcp.vue?vue&type=script&lang=js&":
/*!********************************************************************!*\
  !*** ./resources/js/pages/WithoutEcp.vue?vue&type=script&lang=js& ***!
  \********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_WithoutEcp_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./WithoutEcp.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/WithoutEcp.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_WithoutEcp_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/pages/WithoutEcp.vue?vue&type=template&id=07d83b0a&scoped=true&":
/*!**************************************************************************************!*\
  !*** ./resources/js/pages/WithoutEcp.vue?vue&type=template&id=07d83b0a&scoped=true& ***!
  \**************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_WithoutEcp_vue_vue_type_template_id_07d83b0a_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_WithoutEcp_vue_vue_type_template_id_07d83b0a_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_WithoutEcp_vue_vue_type_template_id_07d83b0a_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./WithoutEcp.vue?vue&type=template&id=07d83b0a&scoped=true& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/WithoutEcp.vue?vue&type=template&id=07d83b0a&scoped=true&");


/***/ })

}]);
//# sourceMappingURL=without-ecp.js.map