"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["contacts"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Contacts.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Contacts.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: "Contacts",
  data: function data() {
    return {
      loading: false,
      contact: {
        question: '',
        communicationType: 'email',
        communication: ''
      },
      phone: '',
      email: ''
    };
  },
  computed: {
    contacts: function contacts() {
      return this.$store.getters.main_contacts;
    }
  },
  methods: {
    submit: function submit() {
      var _this = this;
      this.loading = true;
      axios.post('/api/send/contact', this.contact).then(function (resp) {
        _this.loading = false;
        _this.$store.dispatch('sendNotification', {
          self: _this,
          message: 'Вопрос успешно отправлен'
        });
        _this.contact = {
          question: '',
          communicationType: 'email',
          communication: ''
        };
        _this.$nextTick(function () {
          _this.$refs.observer.reset();
        });
      })["catch"](function (error) {
        // this.$store.dispatch('sendNotification', {self:this, type: 'error'});
        _this.loading = false;
      });
    },
    subscribe: function subscribe() {}
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Contacts.vue?vue&type=template&id=00eaab5f&scoped=true&":
/*!*********************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Contacts.vue?vue&type=template&id=00eaab5f&scoped=true& ***!
  \*********************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render),
/* harmony export */   "staticRenderFns": () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function render() {
  var _vm = this,
    _c = _vm._self._c;
  return _c('div', {
    staticClass: "container bkt-page bkt-container"
  }, [_c('h1', {
    staticClass: "bkt-page__title"
  }, [_vm._v("Контакты")]), _vm._v(" "), _c('bkt-modal', {
    attrs: {
      "id": 'details',
      "title": "Реквизиты Исполнителя",
      "modal_class": "bkt-filters-modal"
    },
    scopedSlots: _vm._u([{
      key: "body",
      fn: function fn() {
        return [_c('div', [_c('p', [_c('strong', [_vm._v("ИП Валигурский С.Д.")])]), _vm._v(" "), _c('p', [_c('strong', [_vm._v("ИНН:")]), _vm._v(" 502982976506 "), _c('strong', [_vm._v("ОГРН:")]), _vm._v(" 318502900011975")]), _vm._v(" "), _c('p', [_vm._v("Российская Федерация, 141014, Московская область, г. Мытищи, ул. Трудовая, д. 32")]), _vm._v(" "), _c('p', [_c('strong', [_vm._v("Расчётный счёт:")]), _vm._v(" 40802810440000043320 в ПАО СБЕРБАНК, г. Москва")]), _vm._v(" "), _c('p', [_c('strong', [_vm._v("Кор. счёт:")]), _vm._v(" 30101810400000000225")]), _vm._v(" "), _c('p', [_c('strong', [_vm._v("БИК:")]), _vm._v(" 044525225")]), _vm._v(" "), _c('strong', [_c('a', {
          staticClass: "bkt-text-primary",
          attrs: {
            "href": _vm.contacts.email ? 'mailto:' + _vm.contacts.email : ''
          }
        }, [_c('skeleton', [_vm._v("\n                            " + _vm._s(_vm.contacts.email ? _vm.contacts.email : '') + "\n                        ")])], 1)])])];
      },
      proxy: true
    }, {
      key: "footer",
      fn: function fn() {
        return [_c('button', {
          staticClass: "bkt-button primary bkt-modal-save",
          attrs: {
            "data-bs-dismiss": "modal"
          }
        }, [_vm._v("\n                    Закрыть\n                ")])];
      },
      proxy: true
    }])
  }), _vm._v(" "), _c('div', {
    staticClass: "bkt-form bkt-form_wide bkt-gap-row-large"
  }, [_c('div', {
    staticClass: "col-12 col-lg-4 bkt-form__offset-right"
  }, [_c('div', {
    staticClass: "bkt-wrapper-column bkt-gap-large"
  }, [_vm.contacts.loading || _vm.contacts.phone ? _c('div', {
    staticClass: "bkt-card__row"
  }, [_c('div', {
    staticClass: "col-12 col-lg-10"
  }, [_c('div', {
    staticClass: "bkt-card__row-column"
  }, [_c('h5', {
    staticClass: "bkt-text-neutral-dark"
  }, [_vm._v("\n                                    телефон\n                                ")]), _vm._v(" "), _c('h4', {
    staticClass: "bkt-card__title"
  }, [_c('skeleton', [_vm._v(_vm._s(_vm.contacts.phone ? _vm.contacts.phone : ''))])], 1), _vm._v(" "), _vm.contacts.phone ? _c('a', {
    staticClass: "bkt-button primary bkt-text-white bkt-w-sm-100",
    attrs: {
      "href": 'tel:' + _vm.contacts.phone
    }
  }, [_vm._v("\n                                    Позвонить\n                                ")]) : _vm._e()])]), _vm._v(" "), _c('div', {
    staticClass: "col-12 col-lg-2 d-none d-lg-block"
  }, [_c('div', {
    staticClass: "bkt-card__category ms-auto bkt-bg-green-lighter"
  }, [_c('span', {
    staticClass: "bkt-card__category-icon"
  }, [_c('bkt-icon', {
    attrs: {
      "name": "Smartphone",
      "color": "green",
      "height": "22px"
    }
  })], 1)])])]) : _vm._e(), _vm._v(" "), _vm.contacts.loading || _vm.contacts.email ? _c('div', {
    staticClass: "bkt-card__row"
  }, [_c('div', {
    staticClass: "col-12 col-lg-10"
  }, [_c('div', {
    staticClass: "bkt-card__row-column"
  }, [_c('h5', {
    staticClass: "bkt-text-neutral-dark"
  }, [_vm._v("\n                                    e-mail\n                                ")]), _vm._v(" "), _c('h4', {
    staticClass: "bkt-card__title"
  }, [_c('skeleton', [_vm._v(_vm._s(_vm.contacts.email ? _vm.contacts.email : ''))])], 1), _vm._v(" "), _vm.contacts.email ? _c('a', {
    staticClass: "bkt-button primary bkt-text-white bkt-w-sm-100",
    attrs: {
      "href": 'mailto:' + _vm.contacts.email
    }
  }, [_vm._v("\n                                    Написать\n                                ")]) : _vm._e()])]), _vm._v(" "), _c('div', {
    staticClass: "col-12 col-lg-2 d-none d-lg-block"
  }, [_c('div', {
    staticClass: "bkt-card__category ms-auto bkt-bg-yellow-lighter"
  }, [_c('span', {
    staticClass: "bkt-card__category-icon"
  }, [_c('bkt-icon', {
    attrs: {
      "name": "Email",
      "color": "yellow"
    }
  })], 1)])])]) : _vm._e(), _vm._v(" "), _c('button', {
    staticClass: "bkt-button bkt-bg-white bkt-text-primary text-uppercase",
    attrs: {
      "data-bs-toggle": "modal",
      "data-bs-target": "#details"
    }
  }, [_vm._v("\n                        реквизиты Исполнителя\n                    ")]), _vm._v(" "), _c('div', {
    staticClass: "bkt-wrapper bkt-gap-small w-100"
  }, [_c('a', {
    staticClass: "bkt-button bkt-button-icon bkt-bg-white flex-fill",
    attrs: {
      "href": "https://vk.com/id741448020",
      "rel": "nofollow noopener",
      "target": "_blank"
    }
  }, [_c('bkt-icon', {
    attrs: {
      "name": "Vk",
      "color": "primary"
    }
  })], 1), _vm._v(" "), _c('a', {
    staticClass: "bkt-button bkt-button-icon bkt-bg-white flex-fill",
    attrs: {
      "href": "https://t.me/lotofond",
      "rel": "nofollow noopener",
      "target": "_blank"
    }
  }, [_c('bkt-icon', {
    attrs: {
      "name": "Telegram",
      "color": "blue"
    }
  })], 1)])])]), _vm._v(" "), _c('div', {
    staticClass: "col-12 col-lg-8"
  }, [_c('div', {
    staticClass: "bkt-wrapper-column bkt-gap-large"
  }, [_c('div', {
    staticClass: "bkt-card bkt-card__body"
  }, [_c('ValidationObserver', {
    ref: "observer",
    staticClass: "bkt-form align-items-end wide",
    attrs: {
      "tag": "div"
    },
    scopedSlots: _vm._u([{
      key: "default",
      fn: function fn(_ref) {
        var invalid = _ref.invalid;
        return [_c('div', {
          staticClass: "col-12"
        }, [_c('bkt-textarea', {
          attrs: {
            "name": "message",
            "field_name": "вопроса",
            "rows": "6",
            "rules": "required",
            "label": "Задайте вопрос или опишите проблему",
            "label_class": "bkt-card__title",
            "no_group_item": ""
          },
          model: {
            value: _vm.contact.question,
            callback: function callback($$v) {
              _vm.$set(_vm.contact, "question", $$v);
            },
            expression: "contact.question"
          }
        })], 1), _vm._v(" "), _c('div', {
          staticClass: "col"
        }, [_c('label', {
          staticClass: "bkt-input__label bkt-form__label mt-0"
        }, [_vm._v("куда вам прислать ответ")]), _vm._v(" "), _c('div', {
          staticClass: "bkt-select__wrapper"
        }, [_c('select', {
          directives: [{
            name: "model",
            rawName: "v-model",
            value: _vm.contact.communicationType,
            expression: "contact.communicationType"
          }],
          staticClass: "form-select bkt-select w-100",
          on: {
            "change": function change($event) {
              var $$selectedVal = Array.prototype.filter.call($event.target.options, function (o) {
                return o.selected;
              }).map(function (o) {
                var val = "_value" in o ? o._value : o.value;
                return val;
              });
              _vm.$set(_vm.contact, "communicationType", $event.target.multiple ? $$selectedVal : $$selectedVal[0]);
            }
          }
        }, [_c('option', {
          attrs: {
            "value": "email"
          }
        }, [_vm._v("E-mail")]), _vm._v(" "), _c('option', {
          attrs: {
            "value": "phone"
          }
        }, [_vm._v("Телефон")])])])]), _vm._v(" "), _c('div', {
          staticClass: "col-12 col-lg-5"
        }, [_vm.contact.communicationType == 'email' ? _c('bkt-input', {
          attrs: {
            "name": 'email',
            "label": "ваш e-mail",
            "field_name": "E-mail",
            "rules": 'required|email',
            "label_class": "bkt-form__label d-lg-none mt-0",
            "no_group_item": "",
            "errors_class": "d-lg-none"
          },
          model: {
            value: _vm.email,
            callback: function callback($$v) {
              _vm.email = $$v;
            },
            expression: "email"
          }
        }) : _vm._e(), _vm._v(" "), _vm.contact.communicationType == 'phone' ? _c('bkt-input', {
          attrs: {
            "name": 'phone',
            "type": "tel",
            "field_name": "Телефон",
            "label": "ваш номер телефона",
            "label_class": "bkt-form__label d-lg-none mt-0",
            "rules": 'required|phone',
            "placeholder": '+7 495 000-00-00',
            "mask": ['+# ### ### ####', '+## ### ### ####', '+## ### #### ####'],
            "no_group_item": "",
            "errors_class": "d-lg-none"
          },
          model: {
            value: _vm.phone,
            callback: function callback($$v) {
              _vm.phone = $$v;
            },
            expression: "phone"
          }
        }) : _vm._e()], 1), _vm._v(" "), _c('div', {
          staticClass: "col"
        }, [_c('button', {
          staticClass: "bkt-button primary bkt-button_plump bkt-w-md-100 float-end",
          attrs: {
            "disabled": invalid
          },
          on: {
            "click": _vm.submit
          }
        }, [_vm.loading ? _c('span', {
          staticClass: "spinner-border spinner-border-sm",
          attrs: {
            "role": "status",
            "aria-hidden": "true"
          }
        }) : _vm._e(), _vm._v("\n                                    Задать вопрос\n                                ")])])];
      }
    }])
  })], 1)])])])], 1);
};
var staticRenderFns = [];


/***/ }),

/***/ "./resources/js/pages/Contacts.vue":
/*!*****************************************!*\
  !*** ./resources/js/pages/Contacts.vue ***!
  \*****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Contacts_vue_vue_type_template_id_00eaab5f_scoped_true___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./Contacts.vue?vue&type=template&id=00eaab5f&scoped=true& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Contacts.vue?vue&type=template&id=00eaab5f&scoped=true&");
/* harmony import */ var _Contacts_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Contacts.vue?vue&type=script&lang=js& */ "./resources/js/pages/Contacts.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_1__["default"])(
  _Contacts_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"],
  _Contacts_vue_vue_type_template_id_00eaab5f_scoped_true___WEBPACK_IMPORTED_MODULE_2__.render,
  _Contacts_vue_vue_type_template_id_00eaab5f_scoped_true___WEBPACK_IMPORTED_MODULE_2__.staticRenderFns,
  false,
  null,
  "00eaab5f",
  null
  
)

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/pages/Contacts.vue?vue&type=script&lang=js&":
/*!******************************************************************!*\
  !*** ./resources/js/pages/Contacts.vue?vue&type=script&lang=js& ***!
  \******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Contacts_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Contacts.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/Contacts.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Contacts_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ })

}]);
//# sourceMappingURL=contacts.js.map