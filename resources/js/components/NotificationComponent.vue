<template>
  <div v-if="hasNotification" class="alert alert-dismissible" :class="[type]">
    <button
      class="close"
      aria-hidden="true"
      type="button"
      data-dismiss="alert"
      @click.prevent="close"
    >×</button>
    <h5 v-if="title">
      <i class="icon fas fa-check"></i>
      {{title}}
    </h5>
    <template v-if="body">{{body}}</template>
  </div>
</template>

<script>
import EventBus from "../event-bus";

export default {
  props: ["eventName"],
  data: () => {
    return {
      hasNotification: false,
      notification: {},
    };
  },
  mounted() {
    this.eventName.forEach((event) => {
      EventBus.$on(event, (payLoad) => {
        this.hasNotification = true;
        this.notification = payLoad;
      });
    });
  },
  computed: {
    type() {
      return this.notification.type || "alert-success";
    },

    body() {
      return this.notification.message || "";
    },
    title() {
      return this.notification.title || "";
    },
  },
  methods: {
    close() {
      this.hasNotification = false;
      this.notification = {};
    },
  },
};
</script>
