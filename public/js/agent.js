"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["agent"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Agent.vue?vue&type=script&lang=js":
/*!******************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Agent.vue?vue&type=script&lang=js ***!
  \******************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _components_CardImageCategory__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../components/CardImageCategory */ "./resources/js/components/CardImageCategory.vue");

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: "Agent",
  components: {
    CardImageCategory: _components_CardImageCategory__WEBPACK_IMPORTED_MODULE_0__["default"]
  },
  data: function data() {
    return {
      loading: false,
      service: {
        name: '',
        email: '',
        phone: '',
        socialsForAnswer: [],
        dateForCallback: '',
        paymentTradingTypes: ['purchaseBidByAgent'],
        terms: false
      }
    };
  },
  computed: {
    selected_lot: function selected_lot() {
      return this.$store.getters.selected_lot;
    }
  },
  methods: {
    sendApplication: function sendApplication() {
      var _this = this;
      this.loading = true;
      var data = JSON.parse(JSON.stringify(this.service));
      // data.socialsForAnswer = [this.service.socialsForAnswer];
      axios.post('/api/send/application', data).then(function (resp) {
        _this.loading = false;
        _this.$store.dispatch('sendNotification', {
          self: _this,
          message: 'Заявка на услугу успешно отправлена менеджеру'
        });
      })["catch"](function (error) {
        _this.loading = false;
      });
    },
    scrollToElement: function scrollToElement() {
      var el = this.$refs.form;
      if (el) {
        el.scrollIntoView({
          block: 'start',
          scrollBehavior: 'smooth'
        });
      }
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Agent.vue?vue&type=template&id=7390abde&scoped=true":
/*!*****************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Agent.vue?vue&type=template&id=7390abde&scoped=true ***!
  \*****************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* binding */ render),
/* harmony export */   staticRenderFns: () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function render() {
  var _vm = this,
    _c = _vm._self._c;
  return _c('div', {
    staticClass: "container bkt-promo bkt-page bkt-container"
  }, [_vm._m(0), _vm._v(" "), _c('section', [_c('h2', {
    staticClass: "bkt-page__subtitle"
  }, [_vm._v("Что это даёт?")]), _vm._v(" "), _c('div', {
    staticClass: "bkt-form row-cols-1 row-cols-md-2 row-cols-lg-5"
  }, [_c('div', {
    staticClass: "col"
  }, [_c('div', {
    staticClass: "bkt-card bkt-promo__profit-card h-100"
  }, [_c('div', {
    staticClass: "bkt-icon-frame-large bkt-bg-blue-lighter"
  }, [_c('bkt-icon', {
    staticClass: "bkt-icon-frame__item",
    attrs: {
      "name": "LightBulb",
      "color": "blue"
    }
  })], 1), _vm._v(" "), _c('p', {
    staticClass: "bkt-card__text my-auto my-md-0"
  }, [_vm._v("Не нужно вникать в тонкости процесса торгов")])])]), _vm._v(" "), _c('div', {
    staticClass: "col"
  }, [_c('div', {
    staticClass: "bkt-card bkt-promo__profit-card h-100"
  }, [_c('div', {
    staticClass: "bkt-icon-frame-large bkt-bg-green-lighter"
  }, [_c('bkt-icon', {
    staticClass: "bkt-icon-frame__item",
    attrs: {
      "name": "Like",
      "color": "green"
    }
  })], 1), _vm._v(" "), _c('p', {
    staticClass: "bkt-card__text my-auto my-md-0"
  }, [_vm._v("\n                            Обходится дешевле, чем покупка ЭЦП\n                        ")])])]), _vm._v(" "), _c('div', {
    staticClass: "col"
  }, [_c('div', {
    staticClass: "bkt-card bkt-promo__profit-card h-100"
  }, [_c('div', {
    staticClass: "bkt-icon-frame-large bkt-bg-yellow-lighter"
  }, [_c('bkt-icon', {
    staticClass: "bkt-icon-frame__item",
    attrs: {
      "name": "Devices",
      "color": "yellow"
    }
  })], 1), _vm._v(" "), _c('p', {
    staticClass: "bkt-card__text my-auto my-md-0"
  }, [_vm._v("Не нужно изучать сервисы и площадки")])])]), _vm._v(" "), _c('div', {
    staticClass: "col"
  }, [_c('div', {
    staticClass: "bkt-card bkt-promo__profit-card h-100"
  }, [_c('div', {
    staticClass: "bkt-icon-frame-large bkt-bg-pink-lighter"
  }, [_c('bkt-icon', {
    staticClass: "bkt-icon-frame__item",
    attrs: {
      "name": "Clipboard",
      "color": "pink"
    }
  })], 1), _vm._v(" "), _c('p', {
    staticClass: "bkt-card__text my-auto my-md-0"
  }, [_vm._v("Гарантируем допуск к торгам")])])]), _vm._v(" "), _c('div', {
    staticClass: "col"
  }, [_c('div', {
    staticClass: "bkt-card bkt-promo__profit-card h-100"
  }, [_c('div', {
    staticClass: "bkt-icon-frame-large bkt-bg-red-lighter"
  }, [_c('bkt-icon', {
    staticClass: "bkt-icon-frame__item",
    attrs: {
      "name": "Clock",
      "color": "red"
    }
  })], 1), _vm._v(" "), _c('p', {
    staticClass: "bkt-card__text my-auto my-md-0"
  }, [_vm._v("Экономим вам время и силы")])])])])]), _vm._v(" "), _vm._m(1), _vm._v(" "), _vm._m(2), _vm._v(" "), _vm._m(3)]);
};
var staticRenderFns = [function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c('section', [_c('h1', {
    staticClass: "bkt-page__title"
  }, [_vm._v("Как работает Лотофонд")]), _vm._v(" "), _c('div', {
    staticClass: "bkt-promo__block-wrapper"
  }, [_c('div', {
    staticClass: "bkt-promo__block bkt-promo__block_agent"
  }, [_c('div', {
    staticClass: "bkt-promo__block-body"
  }, [_c('h1', {
    staticClass: "bkt-promo__block-title"
  }, [_vm._v("Новичок?"), _c('br'), _c('span', {
    staticClass: "bkt-text-yellow"
  }, [_vm._v("сэкономьте до 50%")])]), _vm._v(" "), _c('h5', {
    staticClass: "bkt-promo__block-subtitle"
  }, [_vm._v("на торгах с нашей помощью")]), _vm._v(" "), _c('h4', {
    staticClass: "bkt-promo__block-text"
  }, [_vm._v("\n                            Воспользуйтесь нашим опытом побед, чтобы избежать ошибок и сэкономить время, деньги и\n                            нервы.\n                        ")])]), _vm._v(" "), _c('div', {
    staticClass: "bkt-promo__block-body"
  }, [_c('div', {
    staticClass: "bkt-promo__block-body-column"
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
  })]), _vm._v(" "), _c('div', {
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
  return _c('section', [_c('h2', {
    staticClass: "bkt-page__subtitle"
  }, [_vm._v("Что делаем мы?")]), _vm._v(" "), _c('div', {
    staticClass: "bkt-form bkt-container row-cols-1 row-cols-md-5 row-cols-lg-5"
  }, [_c('div', {
    staticClass: "col"
  }, [_c('div', {
    staticClass: "bkt-promo__action-card"
  }, [_c('div', {
    staticClass: "plus-wrapper"
  }, [_c('div', {
    staticClass: "plus"
  }, [_vm._v("\n                                +\n                            ")])]), _vm._v(" "), _c('h5', {
    staticClass: "bkt-card__text"
  }, [_vm._v("Проводим анализ лота")]), _vm._v(" "), _c('div', {
    staticClass: "number"
  }, [_c('span', [_vm._v("01")])])])]), _vm._v(" "), _c('div', {
    staticClass: "col"
  }, [_c('div', {
    staticClass: "bkt-promo__action-card"
  }, [_c('div', {
    staticClass: "plus-wrapper"
  }, [_c('div', {
    staticClass: "plus"
  }, [_vm._v("\n                                +\n                            ")])]), _vm._v(" "), _c('h5', {
    staticClass: "bkt-card__text"
  }, [_vm._v("Выезжаем на место для получения доп. информации*"), _c('br'), _vm._v(" "), _c('span', {
    staticClass: "bkt-card__subtitle"
  }, [_vm._v("*По Москве и Московской области")])]), _vm._v(" "), _c('div', {
    staticClass: "number"
  }, [_c('span', [_vm._v("02")])])])]), _vm._v(" "), _c('div', {
    staticClass: "col"
  }, [_c('div', {
    staticClass: "bkt-promo__action-card"
  }, [_c('div', {
    staticClass: "plus-wrapper"
  }, [_c('div', {
    staticClass: "plus"
  }, [_vm._v("\n                                +\n                            ")])]), _vm._v(" "), _c('h5', {
    staticClass: "bkt-card__text"
  }, [_vm._v("Даём шаблоны документов по торгам")]), _vm._v(" "), _c('div', {
    staticClass: "number"
  }, [_c('span', [_vm._v("03")])])])]), _vm._v(" "), _c('div', {
    staticClass: "col"
  }, [_c('div', {
    staticClass: "bkt-promo__action-card"
  }, [_c('div', {
    staticClass: "plus-wrapper"
  }, [_c('div', {
    staticClass: "plus"
  }, [_vm._v("\n                                +\n                            ")])]), _vm._v(" "), _c('h5', {
    staticClass: "bkt-card__text"
  }, [_vm._v("Участвуем в торгах от вашего имени")]), _vm._v(" "), _c('div', {
    staticClass: "number"
  }, [_c('span', [_vm._v("04")])])])]), _vm._v(" "), _c('div', {
    staticClass: "col"
  }, [_c('div', {
    staticClass: "bkt-promo__action-card"
  }, [_c('div', {
    staticClass: "plus-wrapper"
  }, [_c('div', {
    staticClass: "plus"
  }, [_vm._v("\n                                +\n                            ")])]), _vm._v(" "), _c('h5', {
    staticClass: "bkt-card__text"
  }, [_vm._v("Контролируем оплату и возврат задатка")]), _vm._v(" "), _c('div', {
    staticClass: "number"
  }, [_c('span', [_vm._v("05")])])])])])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c('section', [_c('h2', {
    staticClass: "bkt-page__subtitle"
  }, [_vm._v("Что от вас?")]), _vm._v(" "), _c('div', {
    staticClass: "bkt-form bkt-container pe-0 justify-content-center row-cols-1 row-cols-md-2 row-cols-lg-4"
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
  }, [_vm._v("Выбрать интересующий лот или обозначить пожелания")])])])]), _vm._v(" "), _c('div', {
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
  }, [_vm._v("Вовремя внести задаток")])])])])])]);
}, function () {
  var _vm = this,
    _c = _vm._self._c;
  return _c('div', {
    staticClass: "bkt-promo__block_mini"
  }, [_c('h2', {
    staticClass: "bkt-promo__block-title"
  }, [_vm._v("С нами "), _c('span', {
    staticClass: "bkt-text-yellow"
  }, [_vm._v("шансы на победу")]), _vm._v(" в торгах\n                увеличиваются до\n            ")]), _c('span', {
    staticClass: "bkt-promo__block-title bkt-text-yellow bkt-promo__block-percentage"
  }, [_vm._v("80%")])]);
}];


/***/ }),

/***/ "./resources/js/pages/Agent.vue":
/*!**************************************!*\
  !*** ./resources/js/pages/Agent.vue ***!
  \**************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Agent_vue_vue_type_template_id_7390abde_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Agent.vue?vue&type=template&id=7390abde&scoped=true */ "./resources/js/pages/Agent.vue?vue&type=template&id=7390abde&scoped=true");
/* harmony import */ var _Agent_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Agent.vue?vue&type=script&lang=js */ "./resources/js/pages/Agent.vue?vue&type=script&lang=js");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Agent_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"],
  _Agent_vue_vue_type_template_id_7390abde_scoped_true__WEBPACK_IMPORTED_MODULE_0__.render,
  _Agent_vue_vue_type_template_id_7390abde_scoped_true__WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "7390abde",
  null
  
)

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/pages/Agent.vue?vue&type=script&lang=js":
/*!**************************************************************!*\
  !*** ./resources/js/pages/Agent.vue?vue&type=script&lang=js ***!
  \**************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Agent_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Agent.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Agent.vue?vue&type=script&lang=js");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Agent_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/pages/Agent.vue?vue&type=template&id=7390abde&scoped=true":
/*!********************************************************************************!*\
  !*** ./resources/js/pages/Agent.vue?vue&type=template&id=7390abde&scoped=true ***!
  \********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Agent_vue_vue_type_template_id_7390abde_scoped_true__WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   staticRenderFns: () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Agent_vue_vue_type_template_id_7390abde_scoped_true__WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_loaders_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Agent_vue_vue_type_template_id_7390abde_scoped_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Agent.vue?vue&type=template&id=7390abde&scoped=true */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Agent.vue?vue&type=template&id=7390abde&scoped=true");


/***/ })

}]);
//# sourceMappingURL=agent.js.map