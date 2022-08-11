"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["messages"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Messages.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Messages.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************************************************************************************************************/
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
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: "Messages",
  components: {},
  data: function data() {
    return {
      info_categories: [{
        id: 1,
        title: 'сообщения платформы',
        color: 'green'
      }, {
        id: 2,
        title: 'избранное',
        color: 'yellow'
      }, {
        id: 3,
        title: 'мониторинг',
        color: 'red'
      }, {
        id: 4,
        title: 'организатор',
        color: 'purple'
      }],
      monitoring_filter: {
        cars: true,
        flats: true
      },
      messages: [{
        img: '',
        note: 'Внимание! Обновление на сайте! Мы улучшили нашу работу, добавив возможность закрепить лот вверху списка.',
        date: '14 марта 2022 в 15:31',
        category: {
          id: 1,
          title: 'сообщения платформы',
          color: 'green'
        },
        read: false
      }, {
        img: 'bmw',
        title: 'БМВ Х5 (ЛОТ №50697876056078)',
        note: 'Прием заявок заканчивается через 3 дня!',
        date: '5 апреля 2022 в 20:00',
        category: {
          id: 2,
          title: 'избранное',
          color: 'yellow'
        },
        read: false
      }, {
        img: 'flat',
        newLot: 'flat',
        title: 'Новые лоты "Квартиры"',
        note: 'ЛОТ №3456743, 3К КВАРТИРА ДОЛГОПРУДНЫЙ',
        date: '12 апреля 2022 в 10:56',
        category: {
          id: 3,
          title: 'мониторинг',
          color: 'red'
        },
        read: true
      }, {
        img: 'bmw',
        title: 'ИВАНОВ НИКОЛАЙ ДМИТРИЕВИЧ',
        note: 'Здравствуйте, Сергей! Пока данных по лоту №83067 нет. Уточняю.',
        date: '5 апреля 2022 в 20:00',
        category: {
          id: 4,
          title: 'организатор',
          color: 'purple'
        },
        read: true
      }, {
        img: '',
        note: 'Сегодня последний день платной подписки. Пожалуйста, не забудьте продлить доступ!',
        date: '14 марта 2022 в 15:31',
        category: {
          id: 1,
          title: 'сообщения платформы',
          color: 'green'
        },
        read: false,
        btnText: 'Продлить подписку'
      }],
      selectedCategory: 0,
      countMessages: {
        all: 0,
        platform: 0,
        favourites: 0,
        monitoring: 0,
        organization: 0
      }
    };
  },
  computed: {
    displayedMessages: function displayedMessages() {
      var _this = this;

      var sortMessages = this.messages.sort(function (a, b) {
        return a.read - b.read;
      });
      return sortMessages.filter(function (data) {
        return _this.selectedCategory == 0 || data.category.id == _this.selectedCategory;
      });
    }
  },
  mounted: function mounted() {
    this.countMessages.all = this.messages.length;
    this.countMessages.platform = this.messages.filter(function (item) {
      return item.category.id == 1 && !item.read;
    }).length;
    this.countMessages.favourites = this.messages.filter(function (item) {
      return item.category.id == 2 && !item.read;
    }).length;
    this.countMessages.monitoring = this.messages.filter(function (item) {
      return item.category.id == 3 && !item.read;
    }).length;
    this.countMessages.organization = this.messages.filter(function (item) {
      return item.category.id == 4 && !item.read;
    }).length;
  }
});

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
/* harmony import */ var _Messages_vue_vue_type_template_id_507785d5_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Messages.vue?vue&type=template&id=507785d5&scoped=true& */ "./resources/js/pages/Messages.vue?vue&type=template&id=507785d5&scoped=true&");
/* harmony import */ var _Messages_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Messages.vue?vue&type=script&lang=js& */ "./resources/js/pages/Messages.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Messages_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Messages_vue_vue_type_template_id_507785d5_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render,
  _Messages_vue_vue_type_template_id_507785d5_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  "507785d5",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/pages/Messages.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/pages/Messages.vue?vue&type=script&lang=js&":
/*!******************************************************************!*\
  !*** ./resources/js/pages/Messages.vue?vue&type=script&lang=js& ***!
  \******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Messages_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Messages.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Messages.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Messages_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/pages/Messages.vue?vue&type=template&id=507785d5&scoped=true&":
/*!************************************************************************************!*\
  !*** ./resources/js/pages/Messages.vue?vue&type=template&id=507785d5&scoped=true& ***!
  \************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Messages_vue_vue_type_template_id_507785d5_scoped_true___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Messages_vue_vue_type_template_id_507785d5_scoped_true___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Messages_vue_vue_type_template_id_507785d5_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Messages.vue?vue&type=template&id=507785d5&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Messages.vue?vue&type=template&id=507785d5&scoped=true&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Messages.vue?vue&type=template&id=507785d5&scoped=true&":
/*!***************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Messages.vue?vue&type=template&id=507785d5&scoped=true& ***!
  \***************************************************************************************************************************************************************************************************************************/
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
    { staticClass: "container bkt-messages bkt-page bkt-container" },
    [
      _c("h1", { staticClass: "bkt-page__title bkt-auctions__title" }, [
        _vm._v("\n            Сообщения\n        "),
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "bkt-content" }, [
        _c("div", { staticClass: "row" }, [
          _c("div", { staticClass: "col-12 col-lg-3" }, [
            _c("div", { staticClass: "bkt-history__chats" }, [
              _c("ul", { staticClass: "list-unstyled text-left pt-4 pb-4" }, [
                _c(
                  "li",
                  {
                    staticClass: "bkt-chat",
                    class: {
                      "bkt-bg-primary-lighter": _vm.selectedCategory == 0,
                    },
                    attrs: { id: "chat-1" },
                    on: {
                      click: function ($event) {
                        _vm.selectedCategory = 0
                      },
                    },
                  },
                  [
                    _c("span", [_vm._v("Все")]),
                    _vm._v(" "),
                    _c(
                      "div",
                      {
                        staticClass:
                          "rounded-pill bkt-bg-primary bkt-text-neutral-light",
                      },
                      [
                        _vm.countMessages.all > 0
                          ? _c("span", { staticClass: "p-2" }, [
                              _vm._v(_vm._s(_vm.countMessages.all)),
                            ])
                          : _vm._e(),
                      ]
                    ),
                  ]
                ),
                _vm._v(" "),
                _c(
                  "li",
                  {
                    staticClass: "bkt-chat",
                    class: {
                      "bkt-bg-green-lighter": _vm.selectedCategory == 1,
                    },
                    attrs: { id: "chat-2" },
                    on: {
                      click: function ($event) {
                        _vm.selectedCategory = 1
                      },
                    },
                  },
                  [
                    _c(
                      "div",
                      { staticClass: "bkt-chat__text" },
                      [
                        _c("bkt-icon", {
                          staticClass: "mr-2",
                          attrs: {
                            name: "Bell",
                            color: "green",
                            width: "15px",
                            height: "15px",
                          },
                        }),
                        _vm._v(" "),
                        _c("span", [_vm._v("Сообщения платформы")]),
                      ],
                      1
                    ),
                    _vm._v(" "),
                    _c(
                      "div",
                      {
                        staticClass:
                          "bkt-chat__num rounded-pill bkt-bg-green bkt-text-neutral-light",
                      },
                      [
                        _vm.countMessages.platform > 0
                          ? _c("span", { staticClass: "p-2" }, [
                              _vm._v(_vm._s(_vm.countMessages.platform)),
                            ])
                          : _vm._e(),
                      ]
                    ),
                  ]
                ),
                _vm._v(" "),
                _c(
                  "li",
                  {
                    staticClass: "bkt-chat",
                    class: {
                      "bkt-bg-yellow-lighter": _vm.selectedCategory == 2,
                    },
                    attrs: { id: "chat-3" },
                    on: {
                      click: function ($event) {
                        _vm.selectedCategory = 2
                      },
                    },
                  },
                  [
                    _c(
                      "div",
                      { staticClass: "bkt-chat__text" },
                      [
                        _c("bkt-icon", {
                          staticClass: "mr-2",
                          attrs: {
                            name: "Star",
                            color: "yellow",
                            width: "15px",
                            height: "15px",
                          },
                        }),
                        _vm._v(" "),
                        _c("span", [_vm._v("Избранное")]),
                      ],
                      1
                    ),
                    _vm._v(" "),
                    _c(
                      "div",
                      {
                        staticClass:
                          "bkt-chat__num rounded-pill bkt-bg-yellow bkt-text-neutral-light",
                      },
                      [
                        _vm.countMessages.favourites > 0
                          ? _c("span", { staticClass: "p-2" }, [
                              _vm._v(_vm._s(_vm.countMessages.favourites)),
                            ])
                          : _vm._e(),
                      ]
                    ),
                  ]
                ),
                _vm._v(" "),
                _c(
                  "li",
                  {
                    staticClass: "bkt-chat",
                    class: { "bkt-bg-red-lighter": _vm.selectedCategory == 3 },
                    attrs: { id: "chat-4" },
                    on: {
                      click: function ($event) {
                        _vm.selectedCategory = 3
                      },
                    },
                  },
                  [
                    _c(
                      "div",
                      { staticClass: "bkt-chat__text" },
                      [
                        _c("bkt-icon", {
                          staticClass: "mr-2",
                          attrs: {
                            name: "Target",
                            color: "red",
                            width: "15px",
                            height: "15px",
                          },
                        }),
                        _vm._v(" "),
                        _c("span", [_vm._v("Мониторинг")]),
                      ],
                      1
                    ),
                    _vm._v(" "),
                    _c(
                      "div",
                      {
                        staticClass:
                          "rounded-pill bkt-bg-red bkt-text-neutral-light",
                      },
                      [
                        _vm.countMessages.monitoring > 0
                          ? _c("span", { staticClass: "p-2" }, [
                              _vm._v(_vm._s(_vm.countMessages.monitoring)),
                            ])
                          : _vm._e(),
                      ]
                    ),
                  ]
                ),
              ]),
            ]),
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "col-12 col-lg-9" }, [
            _c("div", { staticClass: "bkt-history__messages" }, [
              _vm.selectedCategory == 3
                ? _c(
                    "div",
                    { staticClass: "bkt-monitoring-checkboxes text-left mb-4" },
                    [
                      _c("bkt-checkbox", {
                        staticClass: "mr-2",
                        attrs: {
                          value: _vm.monitoring_filter.cars,
                          label: "АВТО",
                          name: "cars",
                          wrapper_class: "bkt-check__wrapper-inline",
                        },
                      }),
                      _vm._v(" "),
                      _c("bkt-checkbox", {
                        attrs: {
                          value: _vm.monitoring_filter.flats,
                          label: "КВАРТИРЫ",
                          name: "flats",
                          wrapper_class: "bkt-check__wrapper-inline",
                        },
                      }),
                    ],
                    1
                  )
                : _vm._e(),
              _vm._v(" "),
              _c(
                "ul",
                { staticClass: "list-unstyled bkt-messages__block" },
                _vm._l(_vm.displayedMessages, function (message, index) {
                  return message
                    ? _c(
                        "li",
                        {
                          key: index,
                          staticClass:
                            "bkt-chat__item d-flex justify-content-between position-relative",
                        },
                        [
                          _c("bkt-icon", {
                            staticClass: "mr-2 position-absolute bkt-icon-done",
                            attrs: {
                              name: "Check",
                              color: message.read ? "primary" : "main-lighter",
                              width: "15px",
                              height: "15px",
                            },
                          }),
                          _vm._v(" "),
                          _c(
                            "div",
                            {
                              staticClass:
                                "d-md-none bkt-item-title d-flex mb-3 text-left",
                            },
                            [
                              _c(
                                "span",
                                { staticClass: "bkt-text-neutral-dark" },
                                [_vm._v(_vm._s(message.date))]
                              ),
                              _vm._v(" "),
                              _c(
                                "div",
                                {
                                  staticClass:
                                    "bkt-chat-content__info text-right",
                                },
                                [
                                  _c(
                                    "p",
                                    {
                                      class:
                                        "bkt-bg-" +
                                        message.category.color +
                                        "-lighter bkt-text-" +
                                        message.category.color,
                                    },
                                    [
                                      _vm._v(
                                        "\n                                            " +
                                          _vm._s(message.category.title) +
                                          "\n                                        "
                                      ),
                                    ]
                                  ),
                                ]
                              ),
                            ]
                          ),
                          _vm._v(" "),
                          _c(
                            "div",
                            { staticClass: "bkt-item-content text-left" },
                            [
                              _c(
                                "div",
                                {
                                  staticClass:
                                    "bkt-content-message d-flex mb-3",
                                },
                                [
                                  message.img
                                    ? _c(
                                        "div",
                                        {
                                          staticClass: "bkt-chat-content__logo",
                                        },
                                        [
                                          _c("img", {
                                            attrs: {
                                              src: "",
                                              alt: "",
                                              width: "100%",
                                              height: "100%",
                                            },
                                          }),
                                        ]
                                      )
                                    : _vm._e(),
                                  _vm._v(" "),
                                  _c(
                                    "div",
                                    { staticClass: "bkt-chat-content__text" },
                                    [
                                      message.title
                                        ? _c(
                                            "p",
                                            {
                                              staticClass: "mb-0",
                                              class: {
                                                "bkt-text-title bkt-arrow-after bkt-cursor-pointer":
                                                  !message.newLot,
                                              },
                                            },
                                            [
                                              _vm._v(
                                                "\n                                                " +
                                                  _vm._s(message.title) +
                                                  "\n                                            "
                                              ),
                                            ]
                                          )
                                        : _vm._e(),
                                      _vm._v(" "),
                                      _c(
                                        "p",
                                        {
                                          staticClass: "mb-0",
                                          class: {
                                            "bkt-text-title bkt-arrow-after bkt-text-hidden bkt-cursor-pointer":
                                              message.newLot,
                                          },
                                        },
                                        [
                                          _vm._v(
                                            "\n                                                " +
                                              _vm._s(message.note)
                                          ),
                                        ]
                                      ),
                                    ]
                                  ),
                                ]
                              ),
                              _vm._v(" "),
                              message.btnText
                                ? _c(
                                    "button",
                                    {
                                      staticClass:
                                        "btn bkt-button p-4 primary mb-3",
                                    },
                                    [
                                      _vm._v(
                                        "\n                                        " +
                                          _vm._s(message.btnText) +
                                          "\n                                    "
                                      ),
                                    ]
                                  )
                                : _vm._e(),
                              _vm._v(" "),
                              _c("br", { staticClass: "d-none d-md-block" }),
                              _vm._v(" "),
                              _c(
                                "span",
                                {
                                  staticClass:
                                    "d-none d-md-block bkt-text-neutral-dark",
                                },
                                [_vm._v(_vm._s(message.date))]
                              ),
                            ]
                          ),
                          _vm._v(" "),
                          _c(
                            "div",
                            {
                              staticClass:
                                "d-none d-md-block bkt-chat-content__info text-right",
                            },
                            [
                              _c(
                                "p",
                                {
                                  class:
                                    "bkt-bg-" +
                                    message.category.color +
                                    "-lighter bkt-text-" +
                                    message.category.color,
                                },
                                [
                                  _vm._v(
                                    "\n                                        " +
                                      _vm._s(message.category.title) +
                                      "\n                                    "
                                  ),
                                ]
                              ),
                            ]
                          ),
                        ],
                        1
                      )
                    : _vm._e()
                }),
                0
              ),
            ]),
          ]),
        ]),
      ]),
    ]
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ })

}]);