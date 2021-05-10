<template>
  <CCard>
    <CCardHeader>
      <slot name="header">
        <CIcon name="cil-grid" /> {{ caption }}
      </slot>
    </CCardHeader>
    <CCardBody>
      <CDataTable
        :hover="true"
        :border="true"
        :items="items"
        :fields="fields"
        :items-per-page="10"
        pagination
      >
        <template #progress="{ item }">
          <td>
            <CProgress
              :value="item.progress"
              :color="getProgressColor(item.progress)"
              show-percentage
              class="mb-2"
            />
          </td>
        </template>
      </CDataTable>
    </CCardBody>
  </CCard>
</template>

<script>
export default {
  name: "Table",
  props: {
    items: Array,
    fields: {
      type: Array,
      default() {
        return ["title", "worker", "created", "progress"];
      },
    },
    caption: {
      type: String,
      default: "Table",
    }
  },
  methods: {
    getProgressColor(progress) {
      return progress == 100
        ? "success"
        : progress >= 51 && progress <= 99
        ? "info"
        : progress >= 20 && progress <= 50
        ? "warning"
        : progress >= 0 && progress <= 19
        ? "danger"
        : "dark";
    },
  },
};
</script>
