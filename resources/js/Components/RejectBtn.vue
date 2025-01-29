<template>
    <button class="reject-btn">Reject</button>
</template>

<style>
.reject-btn {
    background-color: #e74c3c; 
    color: white; 
    border: none; 
    padding: 8px 10px;
    width: 100px; 
    font-size: 13px; 
    font-weight: bold; 
    border-radius: 15px; 
    cursor: pointer; 
    transition: background-color 0.3s, transform 0.2s;
}

.reject-btn:hover {
    background-color: #c0392b; 
    transform: scale(1.05); 
}

.reject-btn:active {
    background-color: #a93226; 
    transform: scale(0.98); 
}
</style>
  