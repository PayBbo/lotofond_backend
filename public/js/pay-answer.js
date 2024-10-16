"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["pay-answer"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/PayAnswer.vue?vue&type=script&lang=js":
/*!**********************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/PayAnswer.vue?vue&type=script&lang=js ***!
  \**********************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: "PayAnswer",
  data: function data() {
    return {
      loading: false,
      status: ''
    };
  },
  mounted: function mounted() {
    this.checkStatus();
  },
  methods: {
    checkStatus: function checkStatus() {
      var _this = this;
      this.loading = true;
      axios.post('/api/payment/check/status', {
        paymentId: this.$route.params.id
      }).then(function (resp) {
        _this.status = resp.data.status;
        _this.loading = false;
      })["catch"](function (error) {
        _this.status = 'error';
        _this.loading = false;
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/PayAnswer.vue?vue&type=template&id=a8f9ac26&scoped=true":
/*!*********************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/PayAnswer.vue?vue&type=template&id=a8f9ac26&scoped=true ***!
  \*********************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* binding */ render),
/* harmony export */   staticRenderFns: () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function render() {
  var _vm = this,
    _c = _vm._self._c;
  return _c('div', {
    staticClass: "bkt-page bkt-container"
  }, [_c('div', {
    staticClass: "bkt-card"
  }, [!_vm.loading ? _c('div', {
    staticClass: "bkt-card__body align-items-center text-center bkt-gap-medium"
  }, [_vm.status === 'Authorized' || _vm.status === 'Settled' ? _c('bkt-icon', {
    attrs: {
      "name": "Check",
      "height": "100px",
      "width": "100px",
      "color": "green"
    }
  }) : _vm._e(), _vm._v(" "), _vm.status === 'Cancelled' || _vm.status === 'Rejected' ? _c('bkt-icon', {
    attrs: {
      "name": "Cancel",
      "height": "100px",
      "width": "100px",
      "color": "red"
    }
  }) : _vm._e(), _vm._v(" "), _vm.status === 'Confirmation' || _vm.status === 'Pending' ? _c('bkt-icon', {
    attrs: {
      "name": "Clock",
      "height": "100px",
      "width": "100px",
      "color": "yellow"
    }
  }) : _vm._e(), _vm._v(" "), _c('h2', {
    staticClass: "bkt-card__title",
    "class": {
      'bkt-text-green': _vm.status === 'Authorized' || _vm.status === 'Settled',
      'bkt-text-red': _vm.status === 'Cancelled' || _vm.status === 'Rejected',
      'bkt-text-yellow': _vm.status === 'Confirmation' || _vm.status === 'Pending'
    }
  }, [_vm._v("\n                " + _vm._s(_vm.$t('payments.' + _vm.status)) + "\n            ")]), _vm._v(" "), _c('a', {
    staticClass: "bkt-button green",
    attrs: {
      "href": "/"
    }
  }, [_vm._v("На главную")])], 1) : _vm._e(), _vm._v(" "), _vm.loading ? _c('div', {
    staticClass: "bkt-card__body align-items-center text-center bkt-gap-medium"
  }, [_c('skeleton', {
    attrs: {
      "type_name": "item",
      "height": "100px",
      "width": "100px"
    }
  }), _vm._v(" "), _c('skeleton', {
    attrs: {
      "type_name": "text",
      "height": "30px",
      "width": "260px"
    }
  }), _vm._v(" "), _c('skeleton', {
    attrs: {
      "type_name": "button",
      "skeleton_class": "bkt-button",
      "width": "140px"
    }
  })], 1) : _vm._e()])]);
};
var staticRenderFns = [];


/***/ }),

/***/ "./resources/js/pages/PayAnswer.vue":
/*!******************************************!*\
  !*** ./resources/js/pages/PayAnswer.vue ***!
  \******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _PayAnswer_vue_vue_type_template_id_a8f9ac26_scoped_true__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./PayAnswer.vue?vue&type=template&id=a8f9ac26&scoped=true */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/loaders/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/PayAnswer.vue?vue&type=template&id=a8f9ac26&scoped=true");
/* harmony import */ var _PayAnswer_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./PayAnswer.vue?vue&type=script&lang=js */ "./resources/js/pages/PayAnswer.vue?vue&type=script&lang=js");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_1__["default"])(
  _PayAnswer_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"],
  _PayAnswer_vue_vue_type_template_id_a8f9ac26_scoped_true__WEBPACK_IMPORTED_MODULE_2__.render,
  _PayAnswer_vue_vue_type_template_id_a8f9ac26_scoped_true__WEBPACK_IMPORTED_MODULE_2__.staticRenderFns,
  false,
  null,
  "a8f9ac26",
  null
  
)

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/pages/PayAnswer.vue?vue&type=script&lang=js":
/*!******************************************************************!*\
  !*** ./resources/js/pages/PayAnswer.vue?vue&type=script&lang=js ***!
  \******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_PayAnswer_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./PayAnswer.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/pages/PayAnswer.vue?vue&type=script&lang=js");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_PayAnswer_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ })

}]);
//# sourceMappingURL=pay-answer.js.map