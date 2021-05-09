<template>
  <div>
    <CRow>
      <CCol sm="12">
        <TaskTable
          :items="getTasksData()"
          hover
          border
          small
          fixed
          caption="MY TASKS"
        />
      </CCol>
    </CRow>
  </div>
</template>

<script>
import TaskTable from "./TaskTable.vue";
import sampleTasksData from "./sampleTasksData";

export default {
  name: "Tables",
  components: { TaskTable },
  methods: {
    getTasksData() {
      return sampleTasksData;
    }
  },
};
</script>
