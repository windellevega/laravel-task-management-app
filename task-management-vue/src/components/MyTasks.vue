<template>
  <div>
    <CRow>
      <CCol sm="12">
        <TaskTable
          :items="getShuffledUsersData()"
          hover
          border
          small
          fixed
          caption="My Tasks"
        />
      </CCol>
    </CRow>
  </div>
</template>

<script>
import TaskTable from "./TaskTable.vue";
import usersData from "./UsersData";

export default {
  name: "Tables",
  components: { TaskTable },
  methods: {
    shuffleArray(array) {
      for (let i = array.length - 1; i > 0; i--) {
        let j = Math.floor(Math.random() * (i + 1));
        let temp = array[i];
        array[i] = array[j];
        array[j] = temp;
      }
      return array;
    },

    getShuffledUsersData() {
      return this.shuffleArray(usersData.slice(0));
    },
  },
};
</script>
