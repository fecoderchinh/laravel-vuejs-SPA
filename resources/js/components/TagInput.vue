<template>
  <div>
    <label>{{ label }}</label>
    <div id="taginput--wrapper" class="tag--wrapper">
      <!--      <ul v-if="isData" class="tag__list">-->
      <!--        <li v-for="(item, index) in dataToShow" :key="index"-->
      <!--            class="badge badge-primary m-1 tag__badge"-->
      <!--        >-->
      <!--          <span class="tag__badge&#45;&#45;name" @click="updateValue(index)">{{ item }}</span>-->
      <!--          <span class="tag__badge&#45;&#45;remove" @click="removeData(index)">x</span>-->
      <!--        </li>-->
      <!--      </ul>-->

      <!--      <input-->
      <!--        v-model="singleData"-->
      <!--        type="text"-->
      <!--        class="tc-input input&#45;&#45;tag"-->
      <!--        :placeholder="placeholder"-->
      <!--        @keydown.enter.prevent="addValue"-->
      <!--        @keydown.delete="removeLast"-->
      <!--      >-->
      <!--      <button class="tc-button tc-button__primary" @click="addValue">-->
      <!--        <fa v-if="loading" :icon="['fas', 'circle-notch']" class="fa-spin" />-->
      <!--        <span v-else>{{ $t('add') }}</span>-->
      <!--      </button>-->

      <div class="search-bar relative text-gray-600 flex-auto">
        <input v-model="singleData"
               type="text"
               :placeholder="placeholder"
               class="input--tag bg-white h-10 w-full px-3 rounded text-sm focus:outline-none text-14px font-lato text-menuItem pr-10 relative"
               @keydown.enter.prevent="addValue"
               @keydown.delete="removeLast"
        >
        <button class="tc-button tc-button__primary tc-button__fill m-0 mr-1 py-1 px-3 absolute right-0 top-50 transform -translate-y-1/2 focus:outline-none"
                @click.prevent="addValue"
        >
          <!--          <fa v-if="loading" :icon="['fas', 'circle-notch']" class="fa-spin" />-->
          <span>{{ $t('add') }}</span>
        </button>
      </div>
    </div>
    <input type="hidden" :name="name" :value="tagInputValue">
    <h3>{{ dataToShow.length }} {{ $t('added_tags') }}</h3>
    <ul v-if="isData" class="tag__list">
      <li v-for="(item, index) in dataToShow" :key="index"
          class="badge badge-primary tag__badge inline-block my-2 mr-2 p-2 bg-gray-300"
      >
        <span class="tag__badge--name" @click="updateValue(index)">{{ item }}</span>
        <span class="tag__badge--remove" @click="removeData(index)">x</span>
      </li>
    </ul>
  </div>
</template>

<script>
import i18n from '~/plugins/i18n'

export default {
  name: 'TagInput',
  props: {
    placeholder: {
      type: String,
      required: false,
      default: i18n.t('please_enter_tag')
    },
    name: {
      type: String,
      required: true
    },
    label: {
      type: String,
      required: false,
      default: 'Tags'
    },
    value: {
      type: String,
      required: false,
      default: ''
    }
  },
  data () {
    return {
      tagInputValue: '',
      singleData: '',
      dataToShow: [],
      loading: false
    }
  },
  computed: {
    isData () {
      return this.dataToShow.length > 0
    }
  },
  watch: {
    value (newValue, oldValue) {
      this.setData(newValue)
    }
  },
  mounted () {
    document.querySelector('#taginput--wrapper').addEventListener('click', function () {
      document.querySelector('.input--tag').focus()
    })

    if (this.value && this.value.length > 1) {
      this.setData(this.value)
    }
  },
  methods: {
    addValue () {
      this.loading = true
      if (this.singleData !== '') {
        this.dataToShow.push(this.singleData)
        this.updateTagValue()
        this.singleData = ''
        this.loading = false
      }
    },
    updateTagValue () {
      this.tagInputValue = this.dataToShow.join(',')

      this.dispatchValue(this.tagInputValue)
    },
    updateValue (index) {
      this.singleData = this.dataToShow[index]
      this.removeData(index)
    },
    removeData (index) {
      this.dataToShow.splice(index, 1)
      this.updateTagValue()
    },
    removeLast () {
      if (this.singleData.length === 0) {
        this.dataToShow.splice(-1, 1)
        this.updateTagValue()
      }
    },
    setData (value) {
      this.dataToShow = value.split(',')
      this.tagInputValue = value
    },
    dispatchValue (value) {
      this.$emit('input', value)
    }
  }
}
</script>

<style scoped lang="scss">
.tag--wrapper {
  border: 1px solid darkcyan;
  border-radius: 2px;
  display: flex;
  flex-wrap: wrap;
  position: relative;
  .input--tag {
    border: none;
    //width: 40% !important;
    outline: none !important;
    transition: none !important;
    box-shadow: none !important;
    &:focus {
      border: none !important;
      box-shadow: none !important;
    }
  }
}
.tag__list {
  margin-bottom: 0px !important;
}
.tag__badge {
  padding: 8px;
  &--name {
    margin-right: 3px;
    cursor: pointer;
  }
  &--remove {
    border-left: 1px solid #e1e1e199;
    padding-left: 5px;
    cursor: pointer;
  }
}
</style>
