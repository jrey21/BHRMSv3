<template>
    <button class="accept-btn">Approve</button>
</template>

<style scoped>
  .accept-btn {
    background-color: #4caf50; 
    color: white; 
    font-weight: bold;
    border: none; 
    width: 100px;
    padding: 8px 10px; 
    font-size: 13px; 
    border-radius: 15px;
    cursor: pointer; 
    transition: background-color 0.3s, transform 0.2s; 
  }

  .accept-btn:hover {
    background-color: #45a049; 
    transform: scale(1.05); 
  }

  .accept-btn:active {
    background-color: #3e8e41;
    transform: scale(0.98); 
  }
</style>
