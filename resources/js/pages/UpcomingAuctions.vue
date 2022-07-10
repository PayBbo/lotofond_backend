<template>
  <div class="container bkt-page bkt-auctions bkt-container">
    <h1 class="bkt-page__title">
      Ближайшие торги
    </h1>
    <div class="bkt-auctions__content p-5 mb-2">
      <div class="bkt-content__buttons d-flex justify-content-between mb-5">
        <div class="bkt-button" style="background: #effbf1">
          <bkt-icon :name="'Home'" :color="'green'" :width="'30px'" :height="'30px'"></bkt-icon>
        </div>
        <div class="bkt-button bkt-bg-blue-lighter">
          <bkt-icon :name="'Cow'" :color="'blue'" :width="'30px'" :height="'30px'"></bkt-icon>
        </div>
        <div class="bkt-button bkt-bg-red-lighter">
          <bkt-icon :name="'Gear'" :color="'red'" :width="'30px'" :height="'30px'"></bkt-icon>
        </div>
        <div class="bkt-button bkt-bg-yellow-lighter">
          <bkt-icon :name="'Wrench'" :color="'yellow'" :width="'30px'" :height="'30px'"></bkt-icon>
        </div>
        <div class="bkt-button" style="background: #eef2fe">
          <bkt-icon :name="'Percentage'" :color="'primary'" :width="'30px'" :height="'30px'"></bkt-icon>
        </div>
        <div class="bkt-button" style="background: #fff0fb">
          <bkt-icon :name="'MechanicalArm'" :color="'purple'" :width="'30px'" :height="'30px'"></bkt-icon>
        </div>
        <div class="bkt-button" style="background: #f5eefd">
          <bkt-icon :name="'Building'" :color="'purple'" :width="'30px'" :height="'30px'"></bkt-icon>
        </div>
        <div class="bkt-button" style="background: #edfcf7">
          <bkt-icon :name="'File'" :color="'green'" :width="'30px'" :height="'30px'"></bkt-icon>
        </div>
        <div class="bkt-button bkt-bg-neutral-light">
          <bkt-icon :name="'More'" :color="'main'" :width="'30px'" :height="'30px'"></bkt-icon>
        </div>
      </div>
      <div class="bkt-content__data">
        <div class="row align-items-baseline text-left bkt-data__item mb-3">
          <div class="col-2">
            <label for="region" class="bkt-select__label">регион</label>
          </div>
          <div class="col-10">
            <div class="bkt-select__wrapper text-left">
              <select id="region" class="bkt-select p-4">
                <option selected value="">Текущая</option>
                <option>One</option>
                <option>Two</option>
              </select>
            </div>
          </div>
        </div>
        <div class="row bkt-data__item mb-3">
          <div class="col-2"></div>
          <div class="col-10">
            <div class="bkt-selected-region float-left d-flex">
              <div class="bkt-region__item bkt-bg-item-rounded bkt-item-rounded mr-2">
                <div class="mb-1 p-2 w-100 pl-4 pr-4 text-left">
                  <span class="bkt-item-rounded__text mr-2">Хабаровский край</span>
                  <span class="bkt-cursor-pointer">
                    <bkt-icon :name="'Cross'"></bkt-icon>
                  </span>
                </div>
              </div>
              <div class="bkt-region__item bkt-bg-item-rounded bkt-item-rounded mr-2">
                <div class="mb-1 p-2 w-100 pl-4 pr-4 text-left">
                  <span class="bkt-item-rounded__text mr-2">Бурятия</span>
                  <span class="bkt-cursor-pointer">
                   <bkt-icon :name="'Cross'"></bkt-icon>
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row align-items-baseline text-left bkt-data__item mb-3">
          <div class="col-2">
            <label for="region" class="bkt-select__label">торговые площадки</label>
          </div>
          <div class="col-10">
            <div class="row">
              <div class="col-12 col-md-3">
                <div class="bkt-select__wrapper text-left">
                  <select id="marketplaces" class="bkt-select p-4">
                    <option selected value="">Все площадки</option>
                    <option>One</option>
                    <option>Two</option>
                  </select>
                </div>
              </div>
              <div class="col-12 col-md-9">
                <div class="bkt-marketplace-checkboxes d-flex h-100 align-items-center justify-content-end">
                  <bkt-checkbox label="Банкротство" name="bankrot" class="mr-3"></bkt-checkbox>
                  <bkt-checkbox label="TorgiGov" name="torgiGov" class="mr-3"></bkt-checkbox>
                  <bkt-checkbox label="Залоговое" name="zalog" class="mr-3"></bkt-checkbox>
                  <bkt-checkbox label="Коммерческое" name="commerce"></bkt-checkbox>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row align-items-baseline text-left bkt-data__item mb-3">
          <div class="col-2">
            <label for="region" class="bkt-select__label">виды торгов</label>
          </div>
          <div class="col-10">
            <div class="row">
              <div class="col-4 text-center">
                <div class="bkt-block-btn bkt-input text-center">
                  Аукцион
                </div>
                <a href="#"><span class="bkt-what-is">что это?</span></a>
              </div>
              <div class="col-4 text-center">
                <div class="bkt-block-btn bkt-input text-center">
                  Публичное предложение
                </div>
                <a href="#"><span class="bkt-what-is">что это?</span></a>
              </div>
            </div>
          </div>
        </div>

        <div class="bkt-auction-price text-left bkt-data__item mb-3">
          <div class="row mb-2" v-for="(price, index) in pricing">
            <div class="col-12 col-md-2 d-flex align-items-center">
              <span class="bkt-auction-price__label">{{ price.title }}</span>
            </div>
            <div class="col-12 col-md-5">
              <bkt-input class="bkt-input-price bkt-input-price__min bkt-auction-price__input"
                         v-model="price.minPrice"
                         :name="'minPrice-'+index" type="text">
                <template #group-item-inner>
                  <button class="bkt-btn-price-done btn bkt-btn-icon position-absolute bkt-bg-white bkt-border-rounded"
                          style="height: 50px; width: 50px; right: 8px" :class="{'active': price.minActive}"
                          @click="price.minActive = !price.minActive">
                    <bkt-icon :name="'Check'" :color="'neutral'" class="bkt-icon"></bkt-icon>
                  </button>
                </template>
              </bkt-input>
            </div>
            <div class="col-12 col-md-5">
              <bkt-input class="bkt-input-price bkt-input-price__max" v-model="price.maxPrice" :name="'maxPrice-'+index"
                         type="text">
                <template #group-item-inner>
                  <button class="bkt-btn-price-done btn bkt-btn-icon position-absolute bkt-bg-white bkt-border-rounded"
                          style="height: 50px; width: 50px; right: 8px" :class="{'active': price.maxActive}"
                          @click="price.maxActive = !price.maxActive">
                    <bkt-icon :name="'Check'" :color="'neutral'" class="bkt-icon"></bkt-icon>
                  </button>
                </template>
              </bkt-input>
            </div>
          </div>
        </div>

        <div class="bkt-auctions-footer bkt-wrapper-between">

            <button type="button" class="btn bkt-btn bkt-button bkt-modal-delete bkt-bg-red-lighter bkt-border-rounded">
              <span class="left_button_inner">
                <bkt-icon :name="'Trash'" :width="'22px'" :height="'22px'"></bkt-icon>
              </span>
            </button>

          <div class="left-block d-flex">
            <div class="block-checkboxes d-flex align-items-center mr-5">
              <bkt-checkbox label="с ближайших" :value="true" name="near"></bkt-checkbox>
              <span class="ml-5 mr-3 bkt-text-neutral">окончание торгов</span>
              <bkt-checkbox label="окончание приёма заявок"  name="applicationTime"></bkt-checkbox>
            </div>
              <button type="button" class="bkt-button primary bkt-button_plump">
                <span role="status"></span>
                Сохранить
              </button>
          </div>
        </div>
      </div>
    </div>

    <div class="bkt-auctions__find p-3">
      <span>НАЙДЕНО 745 ЛОТОВ</span>
      <bkt-icon name="ArrowDown" color="primary"></bkt-icon>
    </div>
  </div>
</template>

<script>
// import Icon from "../../components/Icon";
// import Input from "../../components/Input";
// import Checkbox from "../../components/Checkbox";

export default {
  name: "UpcomingAuctions",
  components: {
    // 'bkt-icon': Icon,
    // 'bkt-input': Input,
    // 'bkt-checkbox': Checkbox
  },
  data() {
    return {
      pricing: [{title: "начальная цена, ₽", minPrice: '', maxPrice: '', minActive: false, maxActive: false},
        {title: "текущая цена, ₽", minPrice: '', maxPrice: '', minActive: false, maxActive: false},
        {title: "минимальная цена, ₽", minPrice: '', maxPrice: '', minActive: false, maxActive: false},
        {title: "процент снижения, %", minPrice: '', maxPrice: '', minActive: false, maxActive: false}],
    }
  },
  mounted() {
    // $(".bkt-monitoring-field__input .bkt-button").click(function () {
    //   $(".bkt-monitoring-field__input .bkt-button").addClass("bkt-text-main").removeClass("shadow green");
    //   $(this).removeClass("bkt-text-main").addClass("shadow green");
    // });
  }
}
</script>

<style scoped>

</style>
