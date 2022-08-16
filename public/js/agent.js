"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["agent"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Agent.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Agent.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************************************************************************************************************************/
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
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
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
  name: "Agent",
  data: function data() {
    return {
      loading: false,
      service: {
        name: '',
        email: '',
        phone: '',
        socialsForAnswer: [],
        date: '',
        terms: false
      }
    };
  },
  methods: {
    sendApplication: function sendApplication() {
      var _this = this;

      this.loading = true;
      axios.post('/api/send/', this.service).then(function (resp) {
        _this.loading = false;
      })["catch"](function (error) {
        _this.loading = false;
      });
    },
    toggleSocial: function toggleSocial(social) {
      var index = this.service.socialsForAnswer.indexOf(social);

      if (index < 0) {
        this.service.socialsForAnswer.push(social);
      } else {
        this.service.socialsForAnswer.splice(index, 1);
      }
    }
  }
});

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
/* harmony import */ var _Agent_vue_vue_type_template_id_3c8100cc_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Agent.vue?vue&type=template&id=3c8100cc&scoped=true& */ "./resources/js/pages/Agent.vue?vue&type=template&id=3c8100cc&scoped=true&");
/* harmony import */ var _Agent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Agent.vue?vue&type=script&lang=js& */ "./resources/js/pages/Agent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Agent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Agent_vue_vue_type_template_id_3c8100cc_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _Agent_vue_vue_type_template_id_3c8100cc_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "3c8100cc",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/pages/Agent.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/pages/Agent.vue?vue&type=script&lang=js&":
/*!***************************************************************!*\
  !*** ./resources/js/pages/Agent.vue?vue&type=script&lang=js& ***!
  \***************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Agent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Agent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Agent.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Agent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/pages/Agent.vue?vue&type=template&id=3c8100cc&scoped=true&":
/*!*********************************************************************************!*\
  !*** ./resources/js/pages/Agent.vue?vue&type=template&id=3c8100cc&scoped=true& ***!
  \*********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Agent_vue_vue_type_template_id_3c8100cc_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Agent_vue_vue_type_template_id_3c8100cc_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Agent_vue_vue_type_template_id_3c8100cc_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Agent.vue?vue&type=template&id=3c8100cc&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Agent.vue?vue&type=template&id=3c8100cc&scoped=true&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Agent.vue?vue&type=template&id=3c8100cc&scoped=true&":
/*!************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Agent.vue?vue&type=template&id=3c8100cc&scoped=true& ***!
  \************************************************************************************************************************************************************************************************************************/
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
    { staticClass: "container bkt-promo bkt-page bkt-container" },
    [
      _vm._m(0),
      _vm._v(" "),
      _c("section", [
        _c("h2", { staticClass: "bkt-page__subtitle" }, [
          _vm._v("Что это даёт?"),
        ]),
        _vm._v(" "),
        _c(
          "div",
          { staticClass: "bkt-form row-cols-1 row-cols-md-2 row-cols-lg-5" },
          [
            _c("div", { staticClass: "col" }, [
              _c(
                "div",
                { staticClass: "bkt-card bkt-promo__profit-card h-100" },
                [
                  _c(
                    "div",
                    { staticClass: "bkt-icon-frame-large bkt-bg-blue-lighter" },
                    [
                      _c("bkt-icon", {
                        staticClass: "bkt-icon-frame__item",
                        attrs: { name: "LightBulb", color: "blue" },
                      }),
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c("p", { staticClass: "bkt-card__text my-auto my-md-0" }, [
                    _vm._v("Не нужно вникать в тонкости процесса торгов"),
                  ]),
                ]
              ),
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "col" }, [
              _c(
                "div",
                { staticClass: "bkt-card bkt-promo__profit-card h-100" },
                [
                  _c(
                    "div",
                    {
                      staticClass: "bkt-icon-frame-large bkt-bg-green-lighter",
                    },
                    [
                      _c("bkt-icon", {
                        staticClass: "bkt-icon-frame__item",
                        attrs: { name: "Like", color: "green" },
                      }),
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c("p", { staticClass: "bkt-card__text my-auto my-md-0" }, [
                    _vm._v(
                      "\n                            Обходится дешевле, чем покупка ЭЦП\n                        "
                    ),
                  ]),
                ]
              ),
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "col" }, [
              _c(
                "div",
                { staticClass: "bkt-card bkt-promo__profit-card h-100" },
                [
                  _c(
                    "div",
                    {
                      staticClass: "bkt-icon-frame-large bkt-bg-yellow-lighter",
                    },
                    [
                      _c("bkt-icon", {
                        staticClass: "bkt-icon-frame__item",
                        attrs: { name: "Devices", color: "yellow" },
                      }),
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c("p", { staticClass: "bkt-card__text my-auto my-md-0" }, [
                    _vm._v("Не нужно изучать сервисы и площадки"),
                  ]),
                ]
              ),
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "col" }, [
              _c(
                "div",
                { staticClass: "bkt-card bkt-promo__profit-card h-100" },
                [
                  _c(
                    "div",
                    { staticClass: "bkt-icon-frame-large bkt-bg-pink-lighter" },
                    [
                      _c("bkt-icon", {
                        staticClass: "bkt-icon-frame__item",
                        attrs: { name: "Clipboard", color: "pink" },
                      }),
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c("p", { staticClass: "bkt-card__text my-auto my-md-0" }, [
                    _vm._v("Гарантируем допуск к торгам"),
                  ]),
                ]
              ),
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "col" }, [
              _c(
                "div",
                { staticClass: "bkt-card bkt-promo__profit-card h-100" },
                [
                  _c(
                    "div",
                    { staticClass: "bkt-icon-frame-large bkt-bg-red-lighter" },
                    [
                      _c("bkt-icon", {
                        staticClass: "bkt-icon-frame__item",
                        attrs: { name: "Clock", color: "red" },
                      }),
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c("p", { staticClass: "bkt-card__text my-auto my-md-0" }, [
                    _vm._v("Экономим вам время и силы"),
                  ]),
                ]
              ),
            ]),
          ]
        ),
      ]),
      _vm._v(" "),
      _vm._m(1),
      _vm._v(" "),
      _vm._m(2),
      _vm._v(" "),
      _vm._m(3),
      _vm._v(" "),
      _c(
        "section",
        [
          _c("h2", { staticClass: "bkt-page__subtitle" }, [
            _vm._v("Как получить услугу?"),
          ]),
          _vm._v(" "),
          _c("ValidationObserver", {
            staticClass: "bkt-card bkt-promo__form bkt-form",
            attrs: { tag: "div" },
            scopedSlots: _vm._u([
              {
                key: "default",
                fn: function (ref) {
                  var invalid = ref.invalid
                  return [
                    _c("bkt-input", {
                      attrs: {
                        name: "name",
                        type: "text",
                        rules: "required|alpha_spaces|min:2",
                        label: "имя фамилия",
                        label_class: "bkt-form__label",
                        field_name: "Имя Фамилия",
                        placeholder: "Иванов Иван",
                        icon_name: "User",
                      },
                      model: {
                        value: _vm.service.name,
                        callback: function ($$v) {
                          _vm.$set(_vm.service, "name", $$v)
                        },
                        expression: "service.name",
                      },
                    }),
                    _vm._v(" "),
                    _c("bkt-input", {
                      attrs: {
                        name: "email",
                        type: "email",
                        label: "email",
                        label_class: "bkt-form__label",
                        field_name: "Email",
                        rules: "required",
                        placeholder: "pochta@gmail.com",
                        icon_name: "Email",
                      },
                      model: {
                        value: _vm.service.email,
                        callback: function ($$v) {
                          _vm.$set(_vm.service, "email", $$v)
                        },
                        expression: "service.email",
                      },
                    }),
                    _vm._v(" "),
                    _c("bkt-input", {
                      attrs: {
                        name: "phone",
                        type: "tel",
                        label: "номер телефона",
                        label_class: "bkt-form__label",
                        field_name: "Номер телефона",
                        rules: "required|phone",
                        placeholder: "+7 495 000-00-00",
                        icon_name: "Smartphone",
                        mask: [
                          "+# ### ### ####",
                          "+## ### ### ####",
                          "+## ### #### ####",
                        ],
                      },
                      model: {
                        value: _vm.service.phone,
                        callback: function ($$v) {
                          _vm.$set(_vm.service, "phone", $$v)
                        },
                        expression: "service.phone",
                      },
                    }),
                    _vm._v(" "),
                    _c("div", { staticClass: "bkt-input__wrapper" }, [
                      _c(
                        "label",
                        {
                          staticClass: "bkt-input__label bkt-form__label",
                          staticStyle: { "margin-bottom": "10px" },
                        },
                        [_vm._v("где вам удобнее общаться")]
                      ),
                      _vm._v(" "),
                      _c("div", { staticClass: "communications" }, [
                        _c(
                          "button",
                          {
                            staticClass: "bkt-button bkt-bg-body",
                            class:
                              _vm.service.socialsForAnswer.indexOf("Viber") >= 0
                                ? "bkt-border-primary"
                                : "bkt-border-body",
                            on: {
                              click: function ($event) {
                                return _vm.toggleSocial("Viber")
                              },
                            },
                          },
                          [
                            _c("bkt-icon", {
                              staticClass: "bkt-button__icon",
                              attrs: { name: "Viber", color: "purple" },
                            }),
                          ],
                          1
                        ),
                        _vm._v(" "),
                        _c(
                          "button",
                          {
                            staticClass: "bkt-button bkt-bg-body",
                            class:
                              _vm.service.socialsForAnswer.indexOf("Vk") >= 0
                                ? "bkt-border-primary"
                                : "bkt-border-body",
                            on: {
                              click: function ($event) {
                                return _vm.toggleSocial("Vk")
                              },
                            },
                          },
                          [
                            _c("bkt-icon", {
                              staticClass: "bkt-button__icon",
                              attrs: { name: "Vk", color: "primary" },
                            }),
                          ],
                          1
                        ),
                        _vm._v(" "),
                        _c(
                          "button",
                          {
                            staticClass: "bkt-button bkt-bg-body",
                            class:
                              _vm.service.socialsForAnswer.indexOf(
                                "Telegram"
                              ) >= 0
                                ? "bkt-border-primary"
                                : "bkt-border-body",
                            on: {
                              click: function ($event) {
                                return _vm.toggleSocial("Telegram")
                              },
                            },
                          },
                          [
                            _c("bkt-icon", {
                              staticClass: "bkt-button__icon",
                              attrs: { name: "Telegram", color: "blue" },
                            }),
                          ],
                          1
                        ),
                        _vm._v(" "),
                        _c(
                          "button",
                          {
                            staticClass: "bkt-button bkt-bg-body",
                            class:
                              _vm.service.socialsForAnswer.indexOf(
                                "WhatsApp"
                              ) >= 0
                                ? "bkt-border-primary"
                                : "bkt-border-body",
                            on: {
                              click: function ($event) {
                                return _vm.toggleSocial("WhatsApp")
                              },
                            },
                          },
                          [
                            _c("bkt-icon", {
                              staticClass: "bkt-button__icon",
                              attrs: { name: "WhatsApp", color: "green" },
                            }),
                          ],
                          1
                        ),
                        _vm._v(" "),
                        _c(
                          "div",
                          {
                            staticClass: "bkt-button bkt-bg-body bkt-text-main",
                          },
                          [_vm._v("перезвоним в течение 10 минут")]
                        ),
                      ]),
                    ]),
                    _vm._v(" "),
                    _c("div", { staticClass: "bkt-input__wrapper" }, [
                      _c("label", { staticClass: "bkt-form__label" }, [
                        _vm._v(
                          "\n                        позвоните лучше\n                    "
                        ),
                      ]),
                      _vm._v(" "),
                      _c(
                        "div",
                        { staticClass: "time_to_call" },
                        [
                          _c("bkt-datepicker", {
                            attrs: {
                              type: "datetime",
                              name: "service.date",
                              field_name: "'позвоните лучше'",
                            },
                            model: {
                              value: _vm.service.date,
                              callback: function ($$v) {
                                _vm.$set(_vm.service, "date", $$v)
                              },
                              expression: "service.date",
                            },
                          }),
                        ],
                        1
                      ),
                    ]),
                    _vm._v(" "),
                    _c("bkt-checkbox", {
                      attrs: {
                        name: "'Условия'",
                        id: "terms",
                        rules: "required_boolean",
                      },
                      scopedSlots: _vm._u(
                        [
                          {
                            key: "label",
                            fn: function () {
                              return [
                                _vm._v(
                                  "\n                        Согласен с условиями пользовательского соглашения, политики сайта, обработки персональных\n                        данных.\n                    "
                                ),
                              ]
                            },
                            proxy: true,
                          },
                        ],
                        null,
                        true
                      ),
                      model: {
                        value: _vm.service.terms,
                        callback: function ($$v) {
                          _vm.$set(_vm.service, "terms", $$v)
                        },
                        expression: "service.terms",
                      },
                    }),
                    _vm._v(" "),
                    _c(
                      "button",
                      {
                        staticClass: "bkt-button primary",
                        attrs: { disabled: invalid || _vm.loading },
                      },
                      [
                        _vm._v(
                          "\n                    Получить услугу\n                "
                        ),
                      ]
                    ),
                  ]
                },
              },
            ]),
          }),
        ],
        1
      ),
    ]
  )
}
var staticRenderFns = [
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("section", [
      _c("h1", { staticClass: "bkt-page__title" }, [
        _vm._v("Покупка через агента"),
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "bkt-promo__block-wrapper" }, [
        _c("div", { staticClass: "bkt-promo__block bkt-promo__block_agent" }, [
          _c("div", { staticClass: "bkt-promo__block-body" }, [
            _c("h1", { staticClass: "bkt-promo__block-title" }, [
              _vm._v("Новичок?"),
              _c("br"),
              _c("span", { staticClass: "bkt-text-yellow" }, [
                _vm._v("сэкономьте до 50%"),
              ]),
            ]),
            _vm._v(" "),
            _c("h5", { staticClass: "bkt-promo__block-subtitle" }, [
              _vm._v("на торгах с нашей помощью"),
            ]),
            _vm._v(" "),
            _c("h4", { staticClass: "bkt-promo__block-text" }, [
              _vm._v(
                "\n                            Воспользуйтесь нашим опытом побед, чтобы избежать ошибок и сэкономить время, деньги и\n                            нервы.\n                        "
              ),
            ]),
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "bkt-promo__block-body" }, [
            _c("div", { staticClass: "bkt-promo__block-body-column" }, [
              _c("div", { staticClass: "bkt-promo__block-feature" }, [
                _c("div", { staticClass: "check_mark bkt-bg-pink" }, [
                  _vm._v("✓"),
                ]),
                _vm._v(" "),
                _c("span", [_vm._v("ЭЦП не нужна")]),
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "bkt-promo__block-feature" }, [
                _c("div", { staticClass: "check_mark bkt-bg-blue" }, [
                  _vm._v("✓"),
                ]),
                _vm._v(" "),
                _c("span", [_vm._v("Аккредитация не нужна")]),
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "bkt-promo__block-feature" }, [
                _c("div", { staticClass: "check_mark bkt-bg-green" }, [
                  _vm._v("✓"),
                ]),
                _vm._v(" "),
                _c("span", [_vm._v("Заполнять документы не нужно")]),
              ]),
            ]),
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "bkt-promo__block-price" }, [
            _c("h2", [_vm._v("3000 ₽")]),
            _vm._v(" "),
            _c(
              "button",
              { staticClass: "bkt-button bkt-button_yellow bkt-button_plump" },
              [_vm._v("Купить")]
            ),
          ]),
        ]),
        _vm._v(" "),
        _c("div", {
          staticClass: "bkt-promo__block-shadow",
          staticStyle: {
            "background-color": "rgba(13, 110, 255, 0.4)",
            "z-index": "-1",
            top: "-5px",
            width: "calc(100% - 5vw)",
          },
        }),
        _vm._v(" "),
        _c("div", {
          staticClass: "bkt-promo__block-shadow",
          staticStyle: {
            "background-color": "rgba(13, 110, 255, 0.2)",
            "z-index": "-2",
            top: "-5px",
            width: "calc(100% - 10vw)",
          },
        }),
      ]),
    ])
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("section", [
      _c("h2", { staticClass: "bkt-page__subtitle" }, [
        _vm._v("Что делаем мы?"),
      ]),
      _vm._v(" "),
      _c(
        "div",
        {
          staticClass:
            "bkt-form bkt-container row-cols-1 row-cols-md-5 row-cols-lg-5",
        },
        [
          _c("div", { staticClass: "col" }, [
            _c("div", { staticClass: "bkt-promo__action-card" }, [
              _c("div", { staticClass: "plus-wrapper" }, [
                _c("div", { staticClass: "plus" }, [
                  _vm._v(
                    "\n                                +\n                            "
                  ),
                ]),
              ]),
              _vm._v(" "),
              _c("h5", { staticClass: "bkt-card__text" }, [
                _vm._v("Проводим анализ лота"),
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "number" }, [
                _c("span", [_vm._v("01")]),
              ]),
            ]),
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "col" }, [
            _c("div", { staticClass: "bkt-promo__action-card" }, [
              _c("div", { staticClass: "plus-wrapper" }, [
                _c("div", { staticClass: "plus" }, [
                  _vm._v(
                    "\n                                +\n                            "
                  ),
                ]),
              ]),
              _vm._v(" "),
              _c("h5", { staticClass: "bkt-card__text" }, [
                _vm._v("Выезжаем на место для получения доп. информации*"),
                _c("br"),
                _vm._v(" "),
                _c("span", { staticClass: "bkt-card__subtitle" }, [
                  _vm._v("*По Москве и Московской области"),
                ]),
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "number" }, [
                _c("span", [_vm._v("02")]),
              ]),
            ]),
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "col" }, [
            _c("div", { staticClass: "bkt-promo__action-card" }, [
              _c("div", { staticClass: "plus-wrapper" }, [
                _c("div", { staticClass: "plus" }, [
                  _vm._v(
                    "\n                                +\n                            "
                  ),
                ]),
              ]),
              _vm._v(" "),
              _c("h5", { staticClass: "bkt-card__text" }, [
                _vm._v("Даём шаблоны документов по торгам"),
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "number" }, [
                _c("span", [_vm._v("03")]),
              ]),
            ]),
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "col" }, [
            _c("div", { staticClass: "bkt-promo__action-card" }, [
              _c("div", { staticClass: "plus-wrapper" }, [
                _c("div", { staticClass: "plus" }, [
                  _vm._v(
                    "\n                                +\n                            "
                  ),
                ]),
              ]),
              _vm._v(" "),
              _c("h5", { staticClass: "bkt-card__text" }, [
                _vm._v("Участвуем в торгах от вашего имени"),
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "number" }, [
                _c("span", [_vm._v("04")]),
              ]),
            ]),
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "col" }, [
            _c("div", { staticClass: "bkt-promo__action-card" }, [
              _c("div", { staticClass: "plus-wrapper" }, [
                _c("div", { staticClass: "plus" }, [
                  _vm._v(
                    "\n                                +\n                            "
                  ),
                ]),
              ]),
              _vm._v(" "),
              _c("h5", { staticClass: "bkt-card__text" }, [
                _vm._v("Контролируем оплату и возврат задатка"),
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "number" }, [
                _c("span", [_vm._v("05")]),
              ]),
            ]),
          ]),
        ]
      ),
    ])
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("section", [
      _c("h2", { staticClass: "bkt-page__subtitle" }, [_vm._v("Что от вас?")]),
      _vm._v(" "),
      _c(
        "div",
        {
          staticClass:
            "bkt-form bkt-container pe-0 justify-content-center row-cols-1 row-cols-md-2 row-cols-lg-4",
        },
        [
          _c("div", { staticClass: "col" }, [
            _c("div", { staticClass: "bkt-promo__todo-card-wrapper h-100" }, [
              _c(
                "div",
                { staticClass: "bkt-card bkt-promo__todo-card h-100" },
                [
                  _c("div", { staticClass: "check-wrapper" }, [
                    _c("div", { staticClass: "check_mark" }, [_vm._v("✓")]),
                  ]),
                  _vm._v(" "),
                  _c("h5", { staticClass: "bkt-card__text" }, [
                    _vm._v("Выбрать интересующий лот или обозначить пожелания"),
                  ]),
                ]
              ),
            ]),
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "col" }, [
            _c("div", { staticClass: "bkt-promo__todo-card-wrapper h-100" }, [
              _c(
                "div",
                { staticClass: "bkt-card bkt-promo__todo-card h-100" },
                [
                  _c("div", { staticClass: "check-wrapper" }, [
                    _c("div", { staticClass: "check_mark" }, [_vm._v("✓")]),
                  ]),
                  _vm._v(" "),
                  _c("h5", { staticClass: "bkt-card__text" }, [
                    _vm._v("Оплатить услугу"),
                  ]),
                ]
              ),
            ]),
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "col" }, [
            _c("div", { staticClass: "bkt-promo__todo-card-wrapper h-100" }, [
              _c(
                "div",
                { staticClass: "bkt-card bkt-promo__todo-card h-100" },
                [
                  _c("div", { staticClass: "check-wrapper" }, [
                    _c("div", { staticClass: "check_mark" }, [_vm._v("✓")]),
                  ]),
                  _vm._v(" "),
                  _c("h5", { staticClass: "bkt-card__text" }, [
                    _vm._v("Заполнить шаблоны документов для участия"),
                  ]),
                ]
              ),
            ]),
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "col" }, [
            _c("div", { staticClass: "bkt-promo__todo-card-wrapper h-100" }, [
              _c(
                "div",
                { staticClass: "bkt-card bkt-promo__todo-card h-100" },
                [
                  _c("div", { staticClass: "check-wrapper" }, [
                    _c("div", { staticClass: "check_mark" }, [_vm._v("✓")]),
                  ]),
                  _vm._v(" "),
                  _c("h5", { staticClass: "bkt-card__text" }, [
                    _vm._v("Вовремя внести задаток"),
                  ]),
                ]
              ),
            ]),
          ]),
        ]
      ),
    ])
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "bkt-promo__block_mini" }, [
      _c("h2", { staticClass: "bkt-promo__block-title" }, [
        _vm._v("С нами "),
        _c("span", { staticClass: "bkt-text-yellow" }, [
          _vm._v("шансы на победу"),
        ]),
        _vm._v(" в торгах\n                увеличиваются до\n            "),
      ]),
      _c(
        "span",
        {
          staticClass:
            "bkt-promo__block-title bkt-text-yellow bkt-promo__block-percentage",
        },
        [_vm._v("80%")]
      ),
    ])
  },
]
render._withStripped = true



/***/ })

}]);