<script setup lang="js">
import { defineProps } from 'vue';

const props = defineProps({
    size: {
        type: Number,
        default: 50
    },
    padding: {
        type: Number,
        default: 8
    },
    color: {
        type: String,
        default: '#fff'
    },
    backgroundColor: {
        type: String,
        default: ''
    }
});
</script>

<template>
<div 
  class="spring-spinner" 
  :style="{ width: `${props.size}px`, height: `${props.size}px`, color: props.color, backgroundColor: props.backgroundColor }"
>
  <div class="spring-spinner-part top" :style="{ height: `${props.size / 2}px`, width: `${props.size}px` }">
    <div 
      class="spring-spinner-rotator" 
      :style="{ 
        width: `${props.size}px`, 
        height: `${props.size}px`, 
        border: `${props.size / 7}px solid transparent`, 
        borderRightColor: props.color, 
        borderTopColor: props.color
      }"
    ></div>
  </div>
  <div class="spring-spinner-part bottom" :style="{ height: `${props.size / 2}px`, width: `${props.size}px` }">
    <div 
      class="spring-spinner-rotator" 
      :style="{ 
        width: `${props.size}px`, 
        height: `${props.size}px`, 
        border: `${props.size / 7}px solid transparent`, 
        borderRightColor: props.color, 
        borderTopColor: props.color
      }"
    ></div>
  </div>
</div>
</template>

<style>
.spring-spinner, .spring-spinner * {
    box-sizing: border-box;
}

.spring-spinner .spring-spinner-part {
    overflow: hidden;
}

.spring-spinner  .spring-spinner-part.bottom {
    transform: rotate(180deg) scale(-1, 1);
}

.spring-spinner .spring-spinner-rotator {
    border-radius: 50%;
    box-sizing: border-box;
    animation: spring-spinner-animation 3s ease-in-out infinite;
    transform: rotate(-200deg);
}

@keyframes spring-spinner-animation {
    0% {
        border-width: calc(60px / 7);
    }
    25% {
        border-width: calc(60px / 23.33);
    }
    50% {
        transform: rotate(115deg);
        border-width: calc(60px / 7);
    }
    75% {
        border-width: calc(60px / 23.33);
    }
    100% {
        border-width: calc(60px / 7);
    }
}
</style>