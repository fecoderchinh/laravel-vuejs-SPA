<template>
  <div id="main-sidebar" class="overflow-hidden h-full bg-white relative z-30">
    <div class="w-full h-16 border-b flex px-4 justify-center items-center md:hidden sm:hidden lg:flex">
      <p class="font-semibold text-3xl text-blue-400 pl-4">
        <img src="https://picsum.photos/240/60" class="mx-auto">
      </p>
    </div>

    <div class="list-sidebar overflow-y-scroll relative overflow-y-scroll pb-24">
      <div v-for="(data, index) in menuData" :key="index" class="flex flex-auto" :class="classSingleItem(index)">
        <template v-if="( !data.subMenu || data.subMenu.length === 0 )">
          <div class="pl-8 pr-4 w-full flex items-center h-8 pl-4 rounded-lg cursor-pointer hover:bg-gray-100">
            <component :is="data.component" class="w-4 h-4 mr-5 fill-current -mt-px" />
            <a v-if="data.modal" href="#" class="text-gray-800 flex-auto text-sm" @click.self.prevent="openModal(data.modal, data.modalW)">{{ data.item }}</a>
            <router-link v-else :to="{name: data.url}" class="text-gray-800 flex-auto text-sm">
              {{ data.item }}
            </router-link>
          </div>
        </template>
        <template v-else>
          <label class="dropdown flex-auto flex-col">

            <div class="dd-button group hover:bg-gray-100 items-center">
              <span class="flex-auto uppercase text-sm">{{ data.item }}</span>
              <div class="flex">
                <carret-svg class="w-3 h-3 flex-auto ml-auto group-hover:fill-current -mt-px" />
              </div>
            </div>

            <input type="checkbox" class="dd-input" checked>

            <ul class="dd-menu">
              <li v-for="(subData, subIndex) in data.subMenu" :key="subIndex">
                <div class="w-full flex items-center h-8 rounded-lg cursor-pointer">
                  <component :is="subData.subComponent" class="w-4 h-4 mr-5 fill-current -mt-px" />
                  <a v-if="subData.modal" href="#" class="text-gray-800 flex-auto text-sm" @click.self.prevent="openModal(subData.modal, subData.modalW)">{{ subData.subItem }}</a>
                  <router-link v-else :to="{name: subData.subUrl}" class="text-gray-800 flex-auto text-sm">{{ subData.subItem }}</router-link>
                </div>
              </li>
            </ul>

          </label>
        </template>
      </div>

      <div class="single-item flex fixed bottom-0 h-10 bg-white flex-auto shadow-fixed w-2/3 md:w-1/3 lg:w-64">
        <div class="pl-8 pr-4 w-full flex items-center h-10 pl-4 rounded-lg cursor-pointer hover:bg-gray-100">
          <setting-svg class="w-4 h-4 mr-5 fill-menuIcon" />
          <router-link :to="{name: 'admin.dashboard'}" class="text-gray-800 flex-auto text-sm">
            Cài đặt
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import TagsModal from '~/components/modals/TagsModal'
export default {
  data () {
    return {
      menuData: [
        {
          item: 'Tổng quan',
          url: 'admin.dashboard',
          component: 'dashboard-svg',
          subMenu: []
        },
        {
          item: 'Đơn hàng',
          url: '#',
          component: 'carret-svg',
          subMenu: [
            {
              subItem: 'Tất cả đơn hàng',
              subUrl: 'admin.tasks.index',
              subComponent: 'file-check-svg'
            },
            {
              subItem: 'Bình luận',
              subUrl: 'admin.comments.index',
              subComponent: 'comment-svg'
            },
            {
              subItem: 'Từ khóa',
              subUrl: 'admin.tags.index',
              subComponent: 'tags-svg',
              modal: TagsModal,
              modalW: 720
            }
          ]
        },
        {
          item: 'Danh mục',
          url: '#',
          component: 'carret-svg',
          subMenu: [
            {
              subItem: 'Tất cả danh mục',
              subUrl: 'admin.categories.index',
              subComponent: 'folder-svg'
            }
          ]
        }
      ]
    }
  },
  created () {
    if (
      this.$store.getters['auth/check'] &&
      this.$store.getters['auth/user'].data.roles
        .map(role => role.slug)
        .map(role => role)
        .some(role => ('admin').includes(role))
    ) {
      var user = {
        item: 'Người dùng',
        url: '#',
        component: 'carret-svg',
        subMenu: [
          {
            subItem: 'Quản lý người dùng',
            subUrl: 'admin.users.index',
            subComponent: 'user-svg'
          }
        ]
      }
      this.menuData.push(user)
    }
  },
  methods: {
    classSingleItem (index) {
      let str = ''
      const d = this.menuData

      if (d[index].subMenu === undefined || d[index].subMenu.length === 0) str += 'single-item '

      if (d.length === index + 1) str += 'last-item '

      return str
    },
    openModal (m, w = 1200) {
      const styles = {
        class: 'cms-modal'
      }
      const options = {
        width: w, height: 'auto', shiftX: 0.5, adaptive: true
      }
      const events = {
        // opened: () => console.log('Opened'),
        closed: () => this.$emit('close')
      }

      this.$modal.show(m, styles, options, events)
    }
  }
}
</script>

<style lang="scss" scoped>
#main-sidebar .list-sidebar {
  @apply h-full select-none;
  width: calc(100% + 17px);
}

@media (pointer:coarse) {
  #main-sidebar .list-sidebar {
    @apply w-full;
  }
}

.dropdown {
  @apply flex relative h-auto font-medium text-base text-gray-800 cursor-pointer;
}

.dd-button {
  @apply flex flex-auto h-10 pl-8 pr-4;
}

.dd-input {
  @apply hidden;
}

.dd-menu {
  @apply relative list-none;
}

.dd-input + .dd-menu {
  @apply hidden;
}

.dd-input:checked + .dd-menu {
  @apply block;
}

.dd-menu li {
  @apply whitespace-no-wrap pl-8 pr-4;
}

.dd-menu li:hover {
  @apply bg-gray-100;
}

.dd-menu li a {
}

.dd-menu li.divider{
  padding: 0;
  border-bottom: 1px solid #cccccc;
}

.single-item {
  & > div {
    @apply rounded-none;
    &:hover, &:focus {
      @apply bg-gray-100;
      & > svg {
        @apply fill-current;
        -webkit-filter: drop-shadow( 1px 1px 1px rgba(0, 0, 0, .3));
        filter: drop-shadow( 1px 1px 1px rgba(0, 0, 0, .3));
      }
      & > a {
        @apply text-blue-500;
      }
    }
    a {
      @apply h-full flex items-center;
    }
  }
  &:first-child {
    @apply mt-4;
  }
}
.last-item {
  @apply mb-24 pb-3;
  @screen sm {
    @apply mb-10 pb-0;
  }
}
.dropdown {
  .dd-menu {
    li {
      & > div {
        @apply rounded-none;
        &:hover, &:focus {
          @apply bg-gray-100;
          & > svg {
            @apply fill-current;
            -webkit-filter: drop-shadow( 1px 1px 1px rgba(0, 0, 0, .3));
            filter: drop-shadow( 1px 1px 1px rgba(0, 0, 0, .3));
          }
          & > a {
            @apply text-blue-500;
          }
        }
        a {
          @apply h-full flex items-center;
        }
      }
    }
  }
}
</style>
