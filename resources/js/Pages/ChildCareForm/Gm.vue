<script setup>
import axios from 'axios';
import { ref, computed } from 'vue';
import { usePage } from '@inertiajs/inertia-vue3';

const { props } = usePage();

const form = ref({
  sex: 'male',
  age: '',
  weight: '',
  height: '',
  zScore: null,
  zScoreHeight: null,
  WFHzScore: null,
});

const maleReferenceData = [
  { age: 0, SD1neg: 2.9, SD0: 3.3, SD1: 3.9 },
  { age: 1, SD1neg: 3.9, SD0: 4.5, SD1: 5.1 },
  { age: 2, SD1neg: 4.9, SD0: 5.6, SD1: 6.3 },
  { age: 3, SD1neg: 5.7, SD0: 6.4, SD1: 7.2 },
  { age: 4, SD1neg: 6.2, SD0: 7, SD1: 7.8 },
  { age: 5, SD1neg: 6.7, SD0: 7.5, SD1: 8.4 },
  { age: 6, SD1neg: 7.1, SD0: 7.9, SD1: 8.8 },
  { age: 7, SD1neg: 7.4, SD0: 8.3, SD1: 9.2 },
  { age: 8, SD1neg: 7.7, SD0: 8.6, SD1: 9.6 },
  { age: 9, SD1neg: 8, SD0: 8.9, SD1: 9.9 },
  { age: 10, SD1neg: 8.2, SD0: 9.2, SD1: 10.2 },
  { age: 11, SD1neg: 8.4, SD0: 9.4, SD1: 10.5 },
  { age: 12, SD1neg: 8.6, SD0: 9.6, SD1: 10.8 },
  { age: 13, SD1neg: 8.8, SD0: 9.9, SD1: 11 },
  { age: 14, SD1neg: 9, SD0: 10.1, SD1: 11.3 },
  { age: 15, SD1neg: 9.2, SD0: 10.3, SD1: 11.5 },
  { age: 16, SD1neg: 9.4, SD0: 10.5, SD1: 11.7 },
  { age: 17, SD1neg: 9.6, SD0: 10.7, SD1: 12 },
  { age: 18, SD1neg: 9.8, SD0: 10.9, SD1: 12.2 },
  { age: 19, SD1neg: 10, SD0: 11.1, SD1: 12.5 },
  { age: 20, SD1neg: 10.1, SD0: 11.3, SD1: 12.7 },
  { age: 21, SD1neg: 10.3, SD0: 11.5, SD1: 12.9 },
  { age: 22, SD1neg: 10.5, SD0: 11.8, SD1: 13.2 },
  { age: 23, SD1neg: 10.7, SD0: 12, SD1: 13.4 },
  { age: 24, SD1neg: 10.8, SD0: 12.2, SD1: 13.6 },
  { age: 25, SD1neg: 11, SD0: 12.4, SD1: 13.9 },
  { age: 26, SD1neg: 11.2, SD0: 12.5, SD1: 14.1 },
  { age: 27, SD1neg: 11.3, SD0: 12.7, SD1: 14.3 },
  { age: 28, SD1neg: 11.5, SD0: 12.9, SD1: 14.5 },
  { age: 29, SD1neg: 11.7, SD0: 13.1, SD1: 14.8 },
  { age: 30, SD1neg: 11.8, SD0: 13.3, SD1: 15 },
  { age: 31, SD1neg: 12, SD0: 13.5, SD1: 15.2 },
  { age: 32, SD1neg: 12.1, SD0: 13.7, SD1: 15.4 },
  { age: 33, SD1neg: 12.3, SD0: 13.8, SD1: 15.6 },
  { age: 34, SD1neg: 12.4, SD0: 14, SD1: 15.8 },
  { age: 35, SD1neg: 12.6, SD0: 14.2, SD1: 16 },
  { age: 36, SD1neg: 12.7, SD0: 14.3, SD1: 16.2 },
  { age: 37, SD1neg: 12.9, SD0: 14.5, SD1: 16.4 },
  { age: 38, SD1neg: 13, SD0: 14.7, SD1: 16.6 },
  { age: 39, SD1neg: 13.1, SD0: 14.8, SD1: 16.8 },
  { age: 40, SD1neg: 13.3, SD0: 15, SD1: 17 },
  { age: 41, SD1neg: 13.4, SD0: 15.2, SD1: 17.2 },
  { age: 42, SD1neg: 13.6, SD0: 15.3, SD1: 17.4 },
  { age: 43, SD1neg: 13.7, SD0: 15.5, SD1: 17.6 },
  { age: 44, SD1neg: 13.8, SD0: 15.7, SD1: 17.8 },
  { age: 45, SD1neg: 14, SD0: 15.8, SD1: 18 },
  { age: 46, SD1neg: 14.1, SD0: 16, SD1: 18.2 },
  { age: 47, SD1neg: 14.3, SD0: 16.2, SD1: 18.4 },
  { age: 48, SD1neg: 14.4, SD0: 16.3, SD1: 18.6 },
  { age: 49, SD1neg: 14.5, SD0: 16.5, SD1: 18.8 },
  { age: 50, SD1neg: 14.7, SD0: 16.7, SD1: 19 },
  { age: 51, SD1neg: 14.8, SD0: 16.8, SD1: 19.2 },
  { age: 52, SD1neg: 15, SD0: 17, SD1: 19.4 },
  { age: 53, SD1neg: 15.1, SD0: 17.2, SD1: 19.6 },
  { age: 54, SD1neg: 15.2, SD0: 17.3, SD1: 19.8 },
  { age: 55, SD1neg: 15.4, SD0: 17.5, SD1: 20 },
  { age: 56, SD1neg: 15.5, SD0: 17.7, SD1: 20.2 },
  { age: 57, SD1neg: 15.6, SD0: 17.8, SD1: 20.4 },
  { age: 58, SD1neg: 15.8, SD0: 18, SD1: 20.6 },
  { age: 59, SD1neg: 15.9, SD0: 18.2, SD1: 20.8 },
  { age: 60, SD1neg: 16, SD0: 18.3, SD1: 21 }
];

const femaleReferenceData = [
  { age: 0, SD1neg: 2.8, SD0: 3.2, SD1: 3.7 },
  { age: 1, SD1neg: 3.6, SD0: 4.2, SD1: 4.8 },
  { age: 2, SD1neg: 4.5, SD0: 5.1, SD1: 5.8 },
  { age: 3, SD1neg: 5.2, SD0: 5.8, SD1: 6.6 },
  { age: 4, SD1neg: 5.7, SD0: 6.4, SD1: 7.3 },
  { age: 5, SD1neg: 6.1, SD0: 6.9, SD1: 7.8 },
  { age: 6, SD1neg: 6.5, SD0: 7.3, SD1: 8.2 },
  { age: 7, SD1neg: 6.8, SD0: 7.6, SD1: 8.6 },
  { age: 8, SD1neg: 7, SD0: 7.9, SD1: 9 },
  { age: 9, SD1neg: 7.3, SD0: 8.2, SD1: 9.3 },
  { age: 10, SD1neg: 7.5, SD0: 8.5, SD1: 9.6 },
  { age: 11, SD1neg: 7.7, SD0: 8.7, SD1: 9.9 },
  { age: 12, SD1neg: 7.9, SD0: 8.9, SD1: 10.1 },
  { age: 13, SD1neg: 8.1, SD0: 9.2, SD1: 10.4 },
  { age: 14, SD1neg: 8.3, SD0: 9.4, SD1: 10.6 },
  { age: 15, SD1neg: 8.5, SD0: 9.6, SD1: 10.9 },
  { age: 16, SD1neg: 8.7, SD0: 9.8, SD1: 11.1 },
  { age: 17, SD1neg: 8.9, SD0: 10, SD1: 11.4 },
  { age: 18, SD1neg: 9.1, SD0: 10.2, SD1: 11.6 },
  { age: 19, SD1neg: 9.2, SD0: 10.4, SD1: 11.8 },
  { age: 20, SD1neg: 9.4, SD0: 10.6, SD1: 12.1 },
  { age: 21, SD1neg: 9.6, SD0: 10.9, SD1: 12.3 },
  { age: 22, SD1neg: 9.8, SD0: 11.1, SD1: 12.5 },
  { age: 23, SD1neg: 10, SD0: 11.3, SD1: 12.8 },
  { age: 24, SD1neg: 10.2, SD0: 11.5, SD1: 13 },
  { age: 25, SD1neg: 10.3, SD0: 11.7, SD1: 13.3 },
  { age: 26, SD1neg: 10.5, SD0: 11.9, SD1: 13.5 },
  { age: 27, SD1neg: 10.7, SD0: 12.1, SD1: 13.7 },
  { age: 28, SD1neg: 10.9, SD0: 12.3, SD1: 14 },
  { age: 29, SD1neg: 11.1, SD0: 12.5, SD1: 14.2 },
  { age: 30, SD1neg: 11.2, SD0: 12.7, SD1: 14.4 },
  { age: 31, SD1neg: 11.4, SD0: 12.9, SD1: 14.7 },
  { age: 32, SD1neg: 11.6, SD0: 13.1, SD1: 14.9 },
  { age: 33, SD1neg: 11.7, SD0: 13.3, SD1: 15.1 },
  { age: 34, SD1neg: 11.9, SD0: 13.5, SD1: 15.4 },
  { age: 35, SD1neg: 12, SD0: 13.7, SD1: 15.6 },
  { age: 36, SD1neg: 12.2, SD0: 13.9, SD1: 15.8 },
  { age: 37, SD1neg: 12.4, SD0: 14, SD1: 16 },
  { age: 38, SD1neg: 12.5, SD0: 14.2, SD1: 16.3 },
  { age: 39, SD1neg: 12.7, SD0: 14.4, SD1: 16.5 },
  { age: 40, SD1neg: 12.8, SD0: 14.6, SD1: 16.7 },
  { age: 41, SD1neg: 13, SD0: 14.8, SD1: 16.9 },
  { age: 42, SD1neg: 13.1, SD0: 15, SD1: 17.2 },
  { age: 43, SD1neg: 13.3, SD0: 15.2, SD1: 17.4 },
  { age: 44, SD1neg: 13.4, SD0: 15.3, SD1: 17.6 },
  { age: 45, SD1neg: 13.6, SD0: 15.5, SD1: 17.8 },
  { age: 46, SD1neg: 13.7, SD0: 15.7, SD1: 18.1 },
  { age: 47, SD1neg: 13.9, SD0: 15.9, SD1: 18.3 },
  { age: 48, SD1neg: 14, SD0: 16.1, SD1: 18.5 },
  { age: 49, SD1neg: 14.2, SD0: 16.3, SD1: 18.8 },
  { age: 50, SD1neg: 14.3, SD0: 16.4, SD1: 19 },
  { age: 51, SD1neg: 14.5, SD0: 16.6, SD1: 19.2 },
  { age: 52, SD1neg: 14.6, SD0: 16.8, SD1: 19.4 },
  { age: 53, SD1neg: 14.8, SD0: 17, SD1: 19.6 },
  { age: 54, SD1neg: 14.9, SD0: 17.2, SD1: 19.9 },
  { age: 55, SD1neg: 15.1, SD0: 17.3, SD1: 20.1 },
  { age: 56, SD1neg: 15.2, SD0: 17.5, SD1: 20.3 },
  { age: 57, SD1neg: 15.3, SD0: 17.7, SD1: 20.6 },
  { age: 58, SD1neg: 15.5, SD0: 17.9, SD1: 20.8 },
  { age: 59, SD1neg: 15.6, SD0: 18, SD1: 21 },
  { age: 60, SD1neg: 15.8, SD0: 18.2, SD1: 21.2 }
];

const femaleHeightReferenceData = [
  { age: 0, SD1neg: 47.3, SD0: 49.1, SD1: 51 },
  { age: 1, SD1neg: 51.7, SD0: 53.7, SD1: 55.6 },
  { age: 2, SD1neg: 55, SD0: 57.1, SD1: 59.1 },
  { age: 3, SD1neg: 57.7, SD0: 59.8, SD1: 61.9 },
  { age: 4, SD1neg: 59.9, SD0: 62.1, SD1: 64.3 },
  { age: 5, SD1neg: 61.8, SD0: 64, SD1: 66.2 },
  { age: 6, SD1neg: 63.5, SD0: 65.7, SD1: 68 },
  { age: 7, SD1neg: 65, SD0: 67.3, SD1: 69.6 },
  { age: 8, SD1neg: 66.4, SD0: 68.7, SD1: 71.1 },
  { age: 9, SD1neg: 67.7, SD0: 70.1, SD1: 72.6 },
  { age: 10, SD1neg: 69, SD0: 71.5, SD1: 73.9 },
  { age: 11, SD1neg: 70.3, SD0: 72.8, SD1: 75.3 },
  { age: 12, SD1neg: 71.4, SD0: 74, SD1: 76.6 },
  { age: 13, SD1neg: 72.6, SD0: 75.2, SD1: 77.8 },
  { age: 14, SD1neg: 73.7, SD0: 76.4, SD1: 79.1 },
  { age: 15, SD1neg: 74.8, SD0: 77.5, SD1: 80.2 },
  { age: 16, SD1neg: 75.8, SD0: 78.6, SD1: 81.4 },
  { age: 17, SD1neg: 76.8, SD0: 79.7, SD1: 82.5 },
  { age: 18, SD1neg: 77.8, SD0: 80.7, SD1: 83.6 },
  { age: 19, SD1neg: 78.8, SD0: 81.7, SD1: 84.7 },
  { age: 20, SD1neg: 79.7, SD0: 82.7, SD1: 85.7 },
  { age: 21, SD1neg: 80.6, SD0: 83.7, SD1: 86.7 },
  { age: 22, SD1neg: 81.5, SD0: 84.6, SD1: 87.7 },
  { age: 23, SD1neg: 82.3, SD0: 85.5, SD1: 88.7 },
  { age: 24, SD1neg: 82.5, SD0: 85.7, SD1: 88.9 },
  { age: 25, SD1neg: 83.3, SD0: 86.6, SD1: 89.9 },
  { age: 26, SD1neg: 84.1, SD0: 87.4, SD1: 90.8 },
  { age: 27, SD1neg: 84.9, SD0: 88.3, SD1: 91.7 },
  { age: 28, SD1neg: 85.7, SD0: 89.1, SD1: 92.5 },
  { age: 29, SD1neg: 86.4, SD0: 89.9, SD1: 93.4 },
  { age: 30, SD1neg: 87.1, SD0: 90.7, SD1: 94.2 },
  { age: 31, SD1neg: 87.9, SD0: 91.4, SD1: 95 },
  { age: 32, SD1neg: 88.6, SD0: 92.2, SD1: 95.8 },
  { age: 33, SD1neg: 89.3, SD0: 92.9, SD1: 96.6 },
  { age: 34, SD1neg: 89.9, SD0: 93.6, SD1: 97.4 },
  { age: 35, SD1neg: 90.6, SD0: 94.4, SD1: 98.1 },
  { age: 36, SD1neg: 91.2, SD0: 95.1, SD1: 98.9 },
  { age: 37, SD1neg: 91.9, SD0: 95.7, SD1: 99.6 },
  { age: 38, SD1neg: 92.5, SD0: 96.4, SD1: 100.3 },
  { age: 39, SD1neg: 93.1, SD0: 97.1, SD1: 101 },
  { age: 40, SD1neg: 93.8, SD0: 97.7, SD1: 101.7 },
  { age: 41, SD1neg: 94.4, SD0: 98.4, SD1: 102.4 },
  { age: 42, SD1neg: 95, SD0: 99, SD1: 103.1 },
  { age: 43, SD1neg: 95.6, SD0: 99.7, SD1: 103.8 },
  { age: 44, SD1neg: 96.2, SD0: 100.3, SD1: 104.5 },
  { age: 45, SD1neg: 96.7, SD0: 100.9, SD1: 105.1 },
  { age: 46, SD1neg: 97.3, SD0: 101.5, SD1: 105.8 },
  { age: 47, SD1neg: 97.9, SD0: 102.1, SD1: 106.4 },
  { age: 48, SD1neg: 98.4, SD0: 102.7, SD1: 107 },
  { age: 49, SD1neg: 99, SD0: 103.3, SD1: 107.7 },
  { age: 50, SD1neg: 99.5, SD0: 103.9, SD1: 108.3 },
  { age: 51, SD1neg: 100.1, SD0: 104.5, SD1: 108.9 },
  { age: 52, SD1neg: 100.6, SD0: 105, SD1: 109.5 },
  { age: 53, SD1neg: 101.1, SD0: 105.6, SD1: 110.1 },
  { age: 54, SD1neg: 101.6, SD0: 106.2, SD1: 110.7 },
  { age: 55, SD1neg: 102.2, SD0: 106.7, SD1: 111.3 },
  { age: 56, SD1neg: 102.7, SD0: 107.3, SD1: 111.9 },
  { age: 57, SD1neg: 103.2, SD0: 107.8, SD1: 112.5 },
  { age: 58, SD1neg: 103.7, SD0: 108.4, SD1: 113 },
  { age: 59, SD1neg: 104.2, SD0: 108.9, SD1: 113.6 },
  { age: 60, SD1neg: 104.7, SD0: 109.4, SD1: 114.2 }
];

const maleHeightReferenceData = [
  { age: 0, SD1neg: 48, SD0: 49.9, SD1: 51.8 },
  { age: 1, SD1neg: 52.8, SD0: 54.7, SD1: 56.7 },
  { age: 2, SD1neg: 56.4, SD0: 58.4, SD1: 60.4 },
  { age: 3, SD1neg: 59.4, SD0: 61.4, SD1: 63.5 },
  { age: 4, SD1neg: 61.8, SD0: 63.9, SD1: 66 },
  { age: 5, SD1neg: 63.8, SD0: 65.9, SD1: 68 },
  { age: 6, SD1neg: 65.5, SD0: 67.6, SD1: 69.8 },
  { age: 7, SD1neg: 67, SD0: 69.2, SD1: 71.3 },
  { age: 8, SD1neg: 68.4, SD0: 70.6, SD1: 72.8 },
  { age: 9, SD1neg: 69.7, SD0: 72, SD1: 74.2 },
  { age: 10, SD1neg: 71, SD0: 73.3, SD1: 75.6 },
  { age: 11, SD1neg: 72.2, SD0: 74.5, SD1: 76.9 },
  { age: 12, SD1neg: 73.4, SD0: 75.7, SD1: 78.1 },
  { age: 13, SD1neg: 74.5, SD0: 76.9, SD1: 79.3 },
  { age: 14, SD1neg: 75.6, SD0: 78, SD1: 80.5 },
  { age: 15, SD1neg: 76.6, SD0: 79.1, SD1: 81.7 },
  { age: 16, SD1neg: 77.6, SD0: 80.2, SD1: 82.8 },
  { age: 17, SD1neg: 78.6, SD0: 81.2, SD1: 83.9 },
  { age: 18, SD1neg: 79.6, SD0: 82.3, SD1: 85 },
  { age: 19, SD1neg: 80.5, SD0: 83.2, SD1: 86 },
  { age: 20, SD1neg: 81.4, SD0: 84.2, SD1: 87 },
  { age: 21, SD1neg: 82.3, SD0: 85.1, SD1: 88 },
  { age: 22, SD1neg: 83.1, SD0: 86, SD1: 89 },
  { age: 23, SD1neg: 83.9, SD0: 86.9, SD1: 89.9 },
  { age: 24, SD1neg: 84.8, SD0: 87.8, SD1: 90.9 },
  { age: 25, SD1neg: 84.9, SD0: 88, SD1: 91.1 },
  { age: 26, SD1neg: 85.6, SD0: 88.8, SD1: 92 },
  { age: 27, SD1neg: 86.4, SD0: 89.6, SD1: 92.9 },
  { age: 28, SD1neg: 87.1, SD0: 90.4, SD1: 93.7 },
  { age: 29, SD1neg: 87.8, SD0: 91.2, SD1: 94.5 },
  { age: 30, SD1neg: 88.5, SD0: 91.9, SD1: 95.3 },
  { age: 31, SD1neg: 89.2, SD0: 92.7, SD1: 96.1 },
  { age: 32, SD1neg: 89.9, SD0: 93.4, SD1: 96.9 },
  { age: 33, SD1neg: 90.5, SD0: 94.1, SD1: 97.6 },
  { age: 34, SD1neg: 91.1, SD0: 94.8, SD1: 98.4 },
  { age: 35, SD1neg: 91.8, SD0: 95.4, SD1: 99.1 },
  { age: 36, SD1neg: 92.4, SD0: 96.1, SD1: 99.8 },
  { age: 37, SD1neg: 93, SD0: 96.7, SD1: 100.5 },
  { age: 38, SD1neg: 93.6, SD0: 97.4, SD1: 101.2 },
  { age: 39, SD1neg: 94.2, SD0: 98, SD1: 101.8 },
  { age: 40, SD1neg: 94.7, SD0: 98.6, SD1: 102.5 },
  { age: 41, SD1neg: 95.3, SD0: 99.2, SD1: 103.2 },
  { age: 42, SD1neg: 95.9, SD0: 99.9, SD1: 103.8 },
  { age: 43, SD1neg: 96.4, SD0: 100.4, SD1: 104.5 },
  { age: 44, SD1neg: 97, SD0: 101, SD1: 105.1 },
  { age: 45, SD1neg: 97.5, SD0: 101.6, SD1: 105.7 },
  { age: 46, SD1neg: 98.1, SD0: 102.2, SD1: 106.3 },
  { age: 47, SD1neg: 98.6, SD0: 102.8, SD1: 106.9 },
  { age: 48, SD1neg: 99.1, SD0: 103.3, SD1: 107.5 },
  { age: 49, SD1neg: 99.7, SD0: 103.9, SD1: 108.1 },
  { age: 50, SD1neg: 100.2, SD0: 104.4, SD1: 108.7 },
  { age: 51, SD1neg: 100.7, SD0: 105, SD1: 109.3 },
  { age: 52, SD1neg: 101.2, SD0: 105.6, SD1: 109.9 },
  { age: 53, SD1neg: 101.7, SD0: 106.1, SD1: 110.5 },
  { age: 54, SD1neg: 102.3, SD0: 106.7, SD1: 111.1 },
  { age: 55, SD1neg: 102.8, SD0: 107.2, SD1: 111.7 },
  { age: 56, SD1neg: 103.3, SD0: 107.8, SD1: 112.3 },
  { age: 57, SD1neg: 103.8, SD0: 108.3, SD1: 112.8 },
  { age: 58, SD1neg: 104.3, SD0: 108.9, SD1: 113.4 },
  { age: 59, SD1neg: 104.8, SD0: 109.4, SD1: 114 },
  { age: 60, SD1neg: 105.3, SD0: 110, SD1: 114.6 }
];

const femaleWeightForHeightReferenceData = [
  { observedHeight: 45, SD1neg: 2.3, SD0: 2.5, SD1: 2.7 },
  { observedHeight: 45.5, SD1neg: 2.3, SD0: 2.5, SD1: 2.8 },
  { observedHeight: 46, SD1neg: 2.4, SD0: 2.6, SD1: 2.9 },
  { observedHeight: 46.5, SD1neg: 2.5, SD0: 2.7, SD1: 3 },
  { observedHeight: 47, SD1neg: 2.6, SD0: 2.8, SD1: 3.1 },
  { observedHeight: 47.5, SD1neg: 2.6, SD0: 2.9, SD1: 3.2 },
  { observedHeight: 48, SD1neg: 2.7, SD0: 3, SD1: 3.3 },
  { observedHeight: 48.5, SD1neg: 2.8, SD0: 3.1, SD1: 3.4 },
  { observedHeight: 49, SD1neg: 2.9, SD0: 3.2, SD1: 3.5 },
  { observedHeight: 49.5, SD1neg: 3, SD0: 3.3, SD1: 3.6 },
  { observedHeight: 50, SD1neg: 3.1, SD0: 3.4, SD1: 3.7 },
  { observedHeight: 50.5, SD1neg: 3.2, SD0: 3.5, SD1: 3.8 },
  { observedHeight: 51, SD1neg: 3.3, SD0: 3.6, SD1: 3.9 },
  { observedHeight: 51.5, SD1neg: 3.4, SD0: 3.7, SD1: 4 },
  { observedHeight: 52, SD1neg: 3.5, SD0: 3.8, SD1: 4.2 },
  { observedHeight: 52.5, SD1neg: 3.6, SD0: 3.9, SD1: 4.3 },
  { observedHeight: 53, SD1neg: 3.7, SD0: 4, SD1: 4.4 },
  { observedHeight: 53.5, SD1neg: 3.8, SD0: 4.2, SD1: 4.6 },
  { observedHeight: 54, SD1neg: 3.9, SD0: 4.3, SD1: 4.7 },
  { observedHeight: 54.5, SD1neg: 4, SD0: 4.4, SD1: 4.8 },
  { observedHeight: 55, SD1neg: 4.2, SD0: 4.5, SD1: 5 },
  { observedHeight: 55.5, SD1neg: 4.3, SD0: 4.7, SD1: 5.1 },
  { observedHeight: 56, SD1neg: 4.4, SD0: 4.8, SD1: 5.3 },
  { observedHeight: 56.5, SD1neg: 4.5, SD0: 5, SD1: 5.4 },
  { observedHeight: 57, SD1neg: 4.6, SD0: 5.1, SD1: 5.6 },
  { observedHeight: 57.5, SD1neg: 4.8, SD0: 5.2, SD1: 5.7 },
  { observedHeight: 58, SD1neg: 4.9, SD0: 5.4, SD1: 5.9 },
  { observedHeight: 58.5, SD1neg: 5, SD0: 5.5, SD1: 6 },
  { observedHeight: 59, SD1neg: 5.1, SD0: 5.6, SD1: 6.2 },
  { observedHeight: 59.5, SD1neg: 5.3, SD0: 5.7, SD1: 6.3 },
  { observedHeight: 60, SD1neg: 5.4, SD0: 5.9, SD1: 6.4 },
  { observedHeight: 60.5, SD1neg: 5.5, SD0: 6, SD1: 6.6 },
  { observedHeight: 61, SD1neg: 5.6, SD0: 6.1, SD1: 6.7 },
  { observedHeight: 61.5, SD1neg: 5.7, SD0: 6.3, SD1: 6.9 },
  { observedHeight: 62, SD1neg: 5.8, SD0: 6.4, SD1: 7 },
  { observedHeight: 62.5, SD1neg: 5.9, SD0: 6.5, SD1: 7.1 },
  { observedHeight: 63, SD1neg: 6, SD0: 6.6, SD1: 7.3 },
  { observedHeight: 63.5, SD1neg: 6.2, SD0: 6.7, SD1: 7.4 },
  { observedHeight: 64, SD1neg: 6.3, SD0: 6.9, SD1: 7.5 },
  { observedHeight: 64.5, SD1neg: 6.4, SD0: 7, SD1: 7.6 },
  { observedHeight: 65, SD1neg: 6.5, SD0: 7.2, SD1: 7.8 },
  { observedHeight: 65.5, SD1neg: 6.6, SD0: 7.3, SD1: 7.9 },
  { observedHeight: 66, SD1neg: 6.7, SD0: 7.4, SD1: 8 },
  { observedHeight: 66.5, SD1neg: 6.8, SD0: 7.5, SD1: 8.1 },
  { observedHeight: 67, SD1neg: 6.9, SD0: 7.6, SD1: 8.3 },
  { observedHeight: 67.5, SD1neg: 7, SD0: 7.7, SD1: 8.4 },
  { observedHeight: 68, SD1neg: 7.1, SD0: 7.9, SD1: 8.5 },
  { observedHeight: 68.5, SD1neg: 7.2, SD0: 8, SD1: 8.6 },
  { observedHeight: 69, SD1neg: 7.3, SD0: 8.1, SD1: 8.7 },
  { observedHeight: 69.5, SD1neg: 7.4, SD0: 8.2, SD1: 8.8 },
  { observedHeight: 70, SD1neg: 7.5, SD0: 8.3, SD1: 9 },
  { observedHeight: 70.5, SD1neg: 7.6, SD0: 8.4, SD1: 9.1 },
  { observedHeight: 71, SD1neg: 7.7, SD0: 8.5, SD1: 9.2 },
  { observedHeight: 71.5, SD1neg: 7.7, SD0: 8.6, SD1: 9.3 },
  { observedHeight: 72, SD1neg: 7.8, SD0: 8.7, SD1: 9.4 },
  { observedHeight: 72.5, SD1neg: 7.9, SD0: 8.8, SD1: 9.5 },
  { observedHeight: 73, SD1neg: 8, SD0: 8.9, SD1: 9.6 },
  { observedHeight: 73.5, SD1neg: 8.1, SD0: 9, SD1: 9.7 },
  { observedHeight: 74, SD1neg: 8.2, SD0: 9.1, SD1: 9.8 },
  { observedHeight: 74.5, SD1neg: 8.3, SD0: 9.1, SD1: 9.9 },
  { observedHeight: 75, SD1neg: 8.4, SD0: 9.2, SD1: 10 },
  { observedHeight: 75.5, SD1neg: 8.5, SD0: 9.3, SD1: 10.1 },
  { observedHeight: 76, SD1neg: 8.5, SD0: 9.4, SD1: 10.2 },
  { observedHeight: 76.5, SD1neg: 8.6, SD0: 9.5, SD1: 10.3 },
  { observedHeight: 77, SD1neg: 8.7, SD0: 9.6, SD1: 10.4 },
  { observedHeight: 77.5, SD1neg: 8.8, SD0: 9.7, SD1: 10.5 },
  { observedHeight: 78, SD1neg: 8.9, SD0: 9.8, SD1: 10.6 },
  { observedHeight: 78.5, SD1neg: 9, SD0: 9.9, SD1: 10.7 },
  { observedHeight: 79, SD1neg: 9.1, SD0: 9.9, SD1: 10.8 },
  { observedHeight: 79.5, SD1neg: 9.1, SD0: 10, SD1: 10.9 },
  { observedHeight: 80, SD1neg: 9.2, SD0: 10.1, SD1: 11 },
  { observedHeight: 80.5, SD1neg: 9.3, SD0: 10.2, SD1: 11.2 },
  { observedHeight: 81, SD1neg: 9.4, SD0: 10.3, SD1: 11.3 },
  { observedHeight: 81.5, SD1neg: 9.5, SD0: 10.4, SD1: 11.4 },
  { observedHeight: 82, SD1neg: 9.6, SD0: 10.5, SD1: 11.5 },
  { observedHeight: 82.5, SD1neg: 9.7, SD0: 10.6, SD1: 11.6 },
  { observedHeight: 83, SD1neg: 9.8, SD0: 10.7, SD1: 11.8 },
  { observedHeight: 83.5, SD1neg: 9.9, SD0: 10.9, SD1: 11.9 },
  { observedHeight: 84, SD1neg: 10.1, SD0: 11, SD1: 12 },
  { observedHeight: 84.5, SD1neg: 10.2, SD0: 11.1, SD1: 12.1 },
  { observedHeight: 85, SD1neg: 10.3, SD0: 11.2, SD1: 12.3 },
  { observedHeight: 85.5, SD1neg: 10.4, SD0: 11.3, SD1: 12.4 },
  { observedHeight: 86, SD1neg: 10.5, SD0: 11.5, SD1: 12.6 },
  { observedHeight: 86.5, SD1neg: 10.6, SD0: 11.6, SD1: 12.7 },
  { observedHeight: 87, SD1neg: 10.7, SD0: 11.7, SD1: 12.8 },
  { observedHeight: 87.5, SD1neg: 10.9, SD0: 11.8, SD1: 13 },
  { observedHeight: 88, SD1neg: 11, SD0: 12, SD1: 13.1 },
  { observedHeight: 88.5, SD1neg: 11.1, SD0: 12.1, SD1: 13.2 },
  { observedHeight: 89, SD1neg: 11.2, SD0: 12.2, SD1: 13.4 },
  { observedHeight: 89.5, SD1neg: 11.3, SD0: 12.3, SD1: 13.5 },
  { observedHeight: 90, SD1neg: 11.4, SD0: 12.5, SD1: 13.7 },
  { observedHeight: 90.5, SD1neg: 11.5, SD0: 12.6, SD1: 13.8 },
  { observedHeight: 91, SD1neg: 11.7, SD0: 12.7, SD1: 13.9 },
  { observedHeight: 91.5, SD1neg: 11.8, SD0: 12.8, SD1: 14.1 },
  { observedHeight: 92, SD1neg: 11.9, SD0: 13, SD1: 14.2 },
  { observedHeight: 92.5, SD1neg: 12, SD0: 13.1, SD1: 14.3 },
  { observedHeight: 93, SD1neg: 12.1, SD0: 13.2, SD1: 14.5 },
  { observedHeight: 93.5, SD1neg: 12.2, SD0: 13.3, SD1: 14.6 },
  { observedHeight: 94, SD1neg: 12.3, SD0: 13.5, SD1: 14.7 },
  { observedHeight: 94.5, SD1neg: 12.4, SD0: 13.6, SD1: 14.9 },
  { observedHeight: 95, SD1neg: 12.6, SD0: 13.7, SD1: 15 },
  { observedHeight: 95.5, SD1neg: 12.7, SD0: 13.8, SD1: 15.2 },
  { observedHeight: 96, SD1neg: 12.8, SD0: 14, SD1: 15.3 },
  { observedHeight: 96.5, SD1neg: 12.9, SD0: 14.1, SD1: 15.4 },
  { observedHeight: 97, SD1neg: 13, SD0: 14.2, SD1: 15.6 },
  { observedHeight: 97.5, SD1neg: 13.1, SD0: 14.4, SD1: 15.7 },
  { observedHeight: 98, SD1neg: 13.3, SD0: 14.5, SD1: 15.9 },
  { observedHeight: 98.5, SD1neg: 13.4, SD0: 14.6, SD1: 16 },
  { observedHeight: 99, SD1neg: 13.5, SD0: 14.8, SD1: 16.2 },
  { observedHeight: 99.5, SD1neg: 13.6, SD0: 14.9, SD1: 16.3 },
  { observedHeight: 100, SD1neg: 13.7, SD0: 15, SD1: 16.5 },
  { observedHeight: 100.5, SD1neg: 13.9, SD0: 15.2, SD1: 16.6 },
  { observedHeight: 101, SD1neg: 14, SD0: 15.3, SD1: 16.8 },
  { observedHeight: 101.5, SD1neg: 14.1, SD0: 15.5, SD1: 17 },
  { observedHeight: 102, SD1neg: 14.3, SD0: 15.6, SD1: 17.1 },
  { observedHeight: 102.5, SD1neg: 14.4, SD0: 15.8, SD1: 17.3 },
  { observedHeight: 103, SD1neg: 14.5, SD0: 15.9, SD1: 17.5 },
  { observedHeight: 103.5, SD1neg: 14.7, SD0: 16.1, SD1: 17.6 },
  { observedHeight: 104, SD1neg: 14.8, SD0: 16.2, SD1: 17.8 },
  { observedHeight: 104.5, SD1neg: 15, SD0: 16.4, SD1: 18 },
  { observedHeight: 105.0, SD1neg: 15.1, SD0: 16.5, SD1: 18.2 },
  { observedHeight: 105.5, SD1neg: 15.3, SD0: 16.7, SD1: 18.4 },
  { observedHeight: 106, SD1neg: 15.4, SD0: 16.9, SD1: 18.5 },
  { observedHeight: 106.5, SD1neg: 15.6, SD0: 17.1, SD1: 18.7 },
  { observedHeight: 107, SD1neg: 15.7, SD0: 17.2, SD1: 18.9 },
  { observedHeight: 107.5, SD1neg: 15.9, SD0: 17.4, SD1: 19.1 },
  { observedHeight: 108, SD1neg: 16, SD0: 17.6, SD1: 19.3 },
  { observedHeight: 108.5, SD1neg: 16.2, SD0: 17.8, SD1: 19.5 },
  { observedHeight: 109, SD1neg: 16.4, SD0: 18, SD1: 19.7 },
  { observedHeight: 109.5, SD1neg: 16.5, SD0: 18.1, SD1: 20 },
  { observedHeight: 110, SD1neg: 16.7, SD0: 18.3, SD1: 20.2 }
];

const femaleWeightForHeightReferenceData24To60 = [
  { observedHeight: 65, SD1neg: 6.6, SD0: 7.2, SD1: 7.9 },
  { observedHeight: 65.5, SD1neg: 6.7, SD0: 7.4, SD1: 8.1 },
  { observedHeight: 66, SD1neg: 6.8, SD0: 7.5, SD1: 8.2 },
  { observedHeight: 66.5, SD1neg: 6.9, SD0: 7.6, SD1: 8.3 },
  { observedHeight: 67, SD1neg: 7, SD0: 7.7, SD1: 8.4 },
  { observedHeight: 67.5, SD1neg: 7.1, SD0: 7.8, SD1: 8.5 },
  { observedHeight: 68, SD1neg: 7.2, SD0: 7.9, SD1: 8.7 },
  { observedHeight: 68.5, SD1neg: 7.3, SD0: 8, SD1: 8.8 },
  { observedHeight: 69, SD1neg: 7.4, SD0: 8.1, SD1: 8.9 },
  { observedHeight: 69.5, SD1neg: 7.5, SD0: 8.2, SD1: 9 },
  { observedHeight: 70, SD1neg: 7.6, SD0: 8.3, SD1: 9.1 },
  { observedHeight: 70.5, SD1neg: 7.7, SD0: 8.4, SD1: 9.2 },
  { observedHeight: 71, SD1neg: 7.8, SD0: 8.5, SD1: 9.3 },
  { observedHeight: 71.5, SD1neg: 7.9, SD0: 8.6, SD1: 9.4 },
  { observedHeight: 72, SD1neg: 8, SD0: 8.7, SD1: 9.5 },
  { observedHeight: 72.5, SD1neg: 8.1, SD0: 8.8, SD1: 9.7 },
  { observedHeight: 73, SD1neg: 8.1, SD0: 8.9, SD1: 9.8 },
  { observedHeight: 73.5, SD1neg: 8.2, SD0: 9, SD1: 9.9 },
  { observedHeight: 74, SD1neg: 8.3, SD0: 9.1, SD1: 10 },
  { observedHeight: 74.5, SD1neg: 8.4, SD0: 9.2, SD1: 10.1 },
  { observedHeight: 75, SD1neg: 8.5, SD0: 9.3, SD1: 10.2 },
  { observedHeight: 75.5, SD1neg: 8.6, SD0: 9.4, SD1: 10.3 },
  { observedHeight: 76, SD1neg: 8.7, SD0: 9.5, SD1: 10.4 },
  { observedHeight: 76.5, SD1neg: 8.7, SD0: 9.6, SD1: 10.5 },
  { observedHeight: 77, SD1neg: 8.8, SD0: 9.6, SD1: 10.6 },
  { observedHeight: 77.5, SD1neg: 8.9, SD0: 9.7, SD1: 10.7 },
  { observedHeight: 78, SD1neg: 9, SD0: 9.8, SD1: 10.8 },
  { observedHeight: 78.5, SD1neg: 9.1, SD0: 9.9, SD1: 10.9 },
  { observedHeight: 79, SD1neg: 9.2, SD0: 10, SD1: 11 },
  { observedHeight: 79.5, SD1neg: 9.3, SD0: 10.1, SD1: 11.1 },
  { observedHeight: 80, SD1neg: 9.4, SD0: 10.2, SD1: 11.2 },
  { observedHeight: 80.5, SD1neg: 9.5, SD0: 10.3, SD1: 11.3 },
  { observedHeight: 81, SD1neg: 9.6, SD0: 10.4, SD1: 11.4 },
  { observedHeight: 81.5, SD1neg: 9.7, SD0: 10.6, SD1: 11.6 },
  { observedHeight: 82, SD1neg: 9.8, SD0: 10.7, SD1: 11.7 },
  { observedHeight: 82.5, SD1neg: 9.9, SD0: 10.8, SD1: 11.8 },
  { observedHeight: 83, SD1neg: 10, SD0: 10.9, SD1: 11.9 },
  { observedHeight: 83.5, SD1neg: 10.1, SD0: 11, SD1: 12.1 },
  { observedHeight: 84, SD1neg: 10.2, SD0: 11.1, SD1: 12.2 },
  { observedHeight: 84.5, SD1neg: 10.3, SD0: 11.3, SD1: 12.3 },
  { observedHeight: 85, SD1neg: 10.4, SD0: 11.4, SD1: 12.5 },
  { observedHeight: 85.5, SD1neg: 10.6, SD0: 11.5, SD1: 12.6 },
  { observedHeight: 86, SD1neg: 10.7, SD0: 11.6, SD1: 12.7 },
  { observedHeight: 86.5, SD1neg: 10.8, SD0: 11.8, SD1: 12.9 },
  { observedHeight: 87, SD1neg: 10.9, SD0: 11.9, SD1: 13 },
  { observedHeight: 87.5, SD1neg: 11, SD0: 12, SD1: 13.2 },
  { observedHeight: 88, SD1neg: 11.1, SD0: 12.1, SD1: 13.3 },
  { observedHeight: 88.5, SD1neg: 11.2, SD0: 12.3, SD1: 13.4 },
  { observedHeight: 89, SD1neg: 11.4, SD0: 12.4, SD1: 13.6 },
  { observedHeight: 89.5, SD1neg: 11.5, SD0: 12.5, SD1: 13.7 },
  { observedHeight: 90, SD1neg: 11.6, SD0: 12.6, SD1: 13.8 },
  { observedHeight: 90.5, SD1neg: 11.7, SD0: 12.8, SD1: 14 },
  { observedHeight: 91, SD1neg: 11.8, SD0: 12.9, SD1: 14.1 },
  { observedHeight: 91.5, SD1neg: 11.9, SD0: 13, SD1: 14.3 },
  { observedHeight: 92, SD1neg: 12, SD0: 13.1, SD1: 14.4 },
  { observedHeight: 92.5, SD1neg: 12.1, SD0: 13.3, SD1: 14.5 },
  { observedHeight: 93, SD1neg: 12.3, SD0: 13.4, SD1: 14.7 },
  { observedHeight: 93.5, SD1neg: 12.4, SD0: 13.5, SD1: 14.8 },
  { observedHeight: 94, SD1neg: 12.5, SD0: 13.6, SD1: 14.9 },
  { observedHeight: 94.5, SD1neg: 12.6, SD0: 13.8, SD1: 15.1 },
  { observedHeight: 95, SD1neg: 12.7, SD0: 13.9, SD1: 15.2 },
  { observedHeight: 95.5, SD1neg: 12.8, SD0: 14, SD1: 15.4 },
  { observedHeight: 96, SD1neg: 12.9, SD0: 14.1, SD1: 15.5 },
  { observedHeight: 96.5, SD1neg: 13.1, SD0: 14.3, SD1: 15.6 },
  { observedHeight: 97, SD1neg: 13.2, SD0: 14.4, SD1: 15.8 },
  { observedHeight: 97.5, SD1neg: 13.3, SD0: 14.5, SD1: 15.9 },
  { observedHeight: 98, SD1neg: 13.4, SD0: 14.7, SD1: 16.1 },
  { observedHeight: 98.5, SD1neg: 13.5, SD0: 14.8, SD1: 16.2 },
  { observedHeight: 99, SD1neg: 13.7, SD0: 14.9, SD1: 16.4 },
  { observedHeight: 99.5, SD1neg: 13.8, SD0: 15.1, SD1: 16.5 },
  { observedHeight: 100, SD1neg: 13.9, SD0: 15.2, SD1: 16.7 },
  { observedHeight: 100.5, SD1neg: 14.1, SD0: 15.4, SD1: 16.9 },
  { observedHeight: 101, SD1neg: 14.2, SD0: 15.5, SD1: 17 },
  { observedHeight: 101.5, SD1neg: 14.3, SD0: 15.7, SD1: 17.2 },
  { observedHeight: 102, SD1neg: 14.5, SD0: 15.8, SD1: 17.4 },
  { observedHeight: 102.5, SD1neg: 14.6, SD0: 16, SD1: 17.5 },
  { observedHeight: 103, SD1neg: 14.7, SD0: 16.1, SD1: 17.7 },
  { observedHeight: 103.5, SD1neg: 14.9, SD0: 16.3, SD1: 17.9 },
  { observedHeight: 104, SD1neg: 15, SD0: 16.4, SD1: 18.1 },
  { observedHeight: 104.5, SD1neg: 15.2, SD0: 16.6, SD1: 18.2 },
  { observedHeight: 105, SD1neg: 15.3, SD0: 16.8, SD1: 18.4 },
  { observedHeight: 105.5, SD1neg: 15.4, SD0: 16.9, SD1: 18.5 },
  { observedHeight: 106, SD1neg: 15.6, SD0: 17.1, SD1: 18.7 },
  { observedHeight: 106.5, SD1neg: 15.7, SD0: 17.3, SD1: 18.9 },
  { observedHeight: 107, SD1neg: 15.9, SD0: 17.5, SD1: 19.1 },
  { observedHeight: 107.5, SD1neg: 16, SD0: 17.7, SD1: 19.3 },
  { observedHeight: 108, SD1neg: 16.2, SD0: 17.8, SD1: 19.5 },
  { observedHeight: 108.5, SD1neg: 16.3, SD0: 18, SD1: 19.7 },
  { observedHeight: 109, SD1neg: 16.5, SD0: 18.1, SD1: 20 },
  { observedHeight: 109.5, SD1neg: 16.6, SD0: 18.3, SD1: 20.2 },
  { observedHeight: 110, SD1neg: 16.8, SD0: 18.5, SD1: 20.4 }
];

const maleWeightForHeightReferenceData = [
  { observedHeight: 47, SD1neg: 2.5, SD0: 2.8, SD1: 3 },
  { observedHeight: 47.5, SD1neg: 2.6, SD0: 2.9, SD1: 3.1 },
  { observedHeight: 48, SD1neg: 2.7, SD0: 2.9, SD1: 3.2 },
  { observedHeight: 48.5, SD1neg: 2.8, SD0: 3, SD1: 3.3 },
  { observedHeight: 49, SD1neg: 2.9, SD0: 3.1, SD1: 3.4 },
  { observedHeight: 49.5, SD1neg: 3, SD0: 3.2, SD1: 3.5 },
  { observedHeight: 50, SD1neg: 3, SD0: 3.3, SD1: 3.6 },
  { observedHeight: 50.5, SD1neg: 3.1, SD0: 3.4, SD1: 3.8 },
  { observedHeight: 51, SD1neg: 3.2, SD0: 3.5, SD1: 3.9 },
  { observedHeight: 51.5, SD1neg: 3.3, SD0: 3.6, SD1: 4 },
  { observedHeight: 52, SD1neg: 3.5, SD0: 3.8, SD1: 4.1 },
  { observedHeight: 52.5, SD1neg: 3.6, SD0: 3.9, SD1: 4.2 },
  { observedHeight: 53, SD1neg: 3.7, SD0: 4, SD1: 4.4 },
  { observedHeight: 53.5, SD1neg: 3.8, SD0: 4.1, SD1: 4.5 },
  { observedHeight: 54, SD1neg: 3.9, SD0: 4.3, SD1: 4.7 },
  { observedHeight: 54.5, SD1neg: 4, SD0: 4.4, SD1: 4.8 },
  { observedHeight: 55, SD1neg: 4.2, SD0: 4.5, SD1: 5 },
  { observedHeight: 55.5, SD1neg: 4.3, SD0: 4.7, SD1: 5.1 },
  { observedHeight: 56, SD1neg: 4.4, SD0: 4.8, SD1: 5.3 },
  { observedHeight: 56.5, SD1neg: 4.6, SD0: 5, SD1: 5.4 },
  { observedHeight: 57, SD1neg: 4.7, SD0: 5.1, SD1: 5.6 },
  { observedHeight: 57.5, SD1neg: 4.9, SD0: 5.3, SD1: 5.7 },
  { observedHeight: 58, SD1neg: 5, SD0: 5.4, SD1: 5.9 },
  { observedHeight: 58.5, SD1neg: 5.1, SD0: 5.6, SD1: 6.1 },
  { observedHeight: 59, SD1neg: 5.3, SD0: 5.7, SD1: 6.2 },
  { observedHeight: 59.5, SD1neg: 5.4, SD0: 5.9, SD1: 6.4 },
  { observedHeight: 60, SD1neg: 5.5, SD0: 6, SD1: 6.5 },
  { observedHeight: 60.5, SD1neg: 5.6, SD0: 6.1, SD1: 6.7 },
  { observedHeight: 61, SD1neg: 5.8, SD0: 6.3, SD1: 6.8 },
  { observedHeight: 61.5, SD1neg: 5.9, SD0: 6.4, SD1: 7 },
  { observedHeight: 62, SD1neg: 6, SD0: 6.5, SD1: 7.1 },
  { observedHeight: 62.5, SD1neg: 6.1, SD0: 6.7, SD1: 7.2 },
  { observedHeight: 63, SD1neg: 6.2, SD0: 6.8, SD1: 7.4 },
  { observedHeight: 63.5, SD1neg: 6.4, SD0: 6.9, SD1: 7.5 },
  { observedHeight: 64, SD1neg: 6.5, SD0: 7, SD1: 7.6 },
  { observedHeight: 64.5, SD1neg: 6.6, SD0: 7.1, SD1: 7.8 },
  { observedHeight: 65, SD1neg: 6.7, SD0: 7.3, SD1: 7.9 },
  { observedHeight: 65.5, SD1neg: 6.8, SD0: 7.4, SD1: 8 },
  { observedHeight: 66, SD1neg: 6.9, SD0: 7.5, SD1: 8.2 },
  { observedHeight: 66.5, SD1neg: 7, SD0: 7.6, SD1: 8.3 },
  { observedHeight: 67, SD1neg: 7.1, SD0: 7.7, SD1: 8.4 },
  { observedHeight: 67.5, SD1neg: 7.2, SD0: 7.9, SD1: 8.5 },
  { observedHeight: 68, SD1neg: 7.3, SD0: 8, SD1: 8.7 },
  { observedHeight: 68.5, SD1neg: 7.5, SD0: 8.1, SD1: 8.8 },
  { observedHeight: 69, SD1neg: 7.6, SD0: 8.2, SD1: 8.9 },
  { observedHeight: 69.5, SD1neg: 7.7, SD0: 8.3, SD1: 9 },
  { observedHeight: 70, SD1neg: 7.8, SD0: 8.4, SD1: 9.2 },
  { observedHeight: 70.5, SD1neg: 7.9, SD0: 8.5, SD1: 9.3 },
  { observedHeight: 71, SD1neg: 8, SD0: 8.6, SD1: 9.4 },
  { observedHeight: 71.5, SD1neg: 8.1, SD0: 8.8, SD1: 9.5 },
  { observedHeight: 72, SD1neg: 8.2, SD0: 8.9, SD1: 9.6 },
  { observedHeight: 72.5, SD1neg: 8.3, SD0: 9, SD1: 9.8 },
  { observedHeight: 73, SD1neg: 8.4, SD0: 9.1, SD1: 9.9 },
  { observedHeight: 73.5, SD1neg: 8.5, SD0: 9.2, SD1: 10 },
  { observedHeight: 74, SD1neg: 8.6, SD0: 9.3, SD1: 10.1 },
  { observedHeight: 74.5, SD1neg: 8.7, SD0: 9.4, SD1: 10.2 },
  { observedHeight: 75, SD1neg: 8.8, SD0: 9.5, SD1: 10.3 },
  { observedHeight: 75.5, SD1neg: 8.8, SD0: 9.6, SD1: 10.4 },
  { observedHeight: 76, SD1neg: 8.9, SD0: 9.7, SD1: 10.6 },
  { observedHeight: 76.5, SD1neg: 9, SD0: 9.8, SD1: 10.7 },
  { observedHeight: 77, SD1neg: 9.1, SD0: 9.9, SD1: 10.8 },
  { observedHeight: 77.5, SD1neg: 9.2, SD0: 10, SD1: 10.9 },
  { observedHeight: 78, SD1neg: 9.3, SD0: 10.1, SD1: 11 },
  { observedHeight: 78.5, SD1neg: 9.4, SD0: 10.2, SD1: 11.1 },
  { observedHeight: 79, SD1neg: 9.5, SD0: 10.3, SD1: 11.2 },
  { observedHeight: 79.5, SD1neg: 9.5, SD0: 10.4, SD1: 11.3 },
  { observedHeight: 80, SD1neg: 9.6, SD0: 10.4, SD1: 11.4 },
  { observedHeight: 80.5, SD1neg: 9.7, SD0: 10.5, SD1: 11.5 },
  { observedHeight: 81, SD1neg: 9.8, SD0: 10.6, SD1: 11.6 },
  { observedHeight: 81.5, SD1neg: 9.9, SD0: 10.7, SD1: 11.7 },
  { observedHeight: 82, SD1neg: 10, SD0: 10.8, SD1: 11.8 },
  { observedHeight: 82.5, SD1neg: 10.1, SD0: 10.9, SD1: 11.9 },
  { observedHeight: 83, SD1neg: 10.2, SD0: 11, SD1: 12 },
  { observedHeight: 83.5, SD1neg: 10.3, SD0: 11.2, SD1: 12.1 },
  { observedHeight: 84, SD1neg: 10.4, SD0: 11.3, SD1: 12.2 },
  { observedHeight: 84.5, SD1neg: 10.5, SD0: 11.4, SD1: 12.4 },
  { observedHeight: 85, SD1neg: 10.6, SD0: 11.5, SD1: 12.5 },
  { observedHeight: 85.5, SD1neg: 10.7, SD0: 11.6, SD1: 12.6 },
  { observedHeight: 86, SD1neg: 10.8, SD0: 11.7, SD1: 12.8 },
  { observedHeight: 86.5, SD1neg: 11, SD0: 11.9, SD1: 12.9 },
  { observedHeight: 87, SD1neg: 11.1, SD0: 12, SD1: 13 },
  { observedHeight: 87.5, SD1neg: 11.2, SD0: 12.1, SD1: 13.2 },
  { observedHeight: 88, SD1neg: 11.3, SD0: 12.2, SD1: 13.3 },
  { observedHeight: 88.5, SD1neg: 11.4, SD0: 12.4, SD1: 13.4 },
  { observedHeight: 89, SD1neg: 11.5, SD0: 12.5, SD1: 13.5 },
  { observedHeight: 89.5, SD1neg: 11.6, SD0: 12.6, SD1: 13.7 },
  { observedHeight: 90, SD1neg: 11.8, SD0: 12.7, SD1: 13.8 },
  { observedHeight: 90.5, SD1neg: 11.9, SD0: 12.8, SD1: 13.9 },
  { observedHeight: 91, SD1neg: 12, SD0: 13, SD1: 14.1 },
  { observedHeight: 91.5, SD1neg: 12.1, SD0: 13.1, SD1: 14.2 },
  { observedHeight: 92, SD1neg: 12.2, SD0: 13.2, SD1: 14.3 },
  { observedHeight: 92.5, SD1neg: 12.3, SD0: 13.3, SD1: 14.4 },
  { observedHeight: 93, SD1neg: 12.4, SD0: 13.4, SD1: 14.6 },
  { observedHeight: 93.5, SD1neg: 12.5, SD0: 13.5, SD1: 14.7 },
  { observedHeight: 94, SD1neg: 12.6, SD0: 13.7, SD1: 14.8 },
  { observedHeight: 94.5, SD1neg: 12.7, SD0: 13.8, SD1: 14.9 },
  { observedHeight: 95, SD1neg: 12.8, SD0: 13.9, SD1: 15.1 },
  { observedHeight: 95.5, SD1neg: 12.9, SD0: 14, SD1: 15.2 },
  { observedHeight: 96, SD1neg: 13.1, SD0: 14.1, SD1: 15.3 },
  { observedHeight: 96.5, SD1neg: 13.2, SD0: 14.3, SD1: 15.5 },
  { observedHeight: 97, SD1neg: 13.3, SD0: 14.4, SD1: 15.6 },
  { observedHeight: 97.5, SD1neg: 13.4, SD0: 14.5, SD1: 15.7 },
  { observedHeight: 98, SD1neg: 13.5, SD0: 14.6, SD1: 15.9 },
  { observedHeight: 98.5, SD1neg: 13.6, SD0: 14.8, SD1: 16 },
  { observedHeight: 99, SD1neg: 13.7, SD0: 14.9, SD1: 16.2 },
  { observedHeight: 99.5, SD1neg: 13.9, SD0: 15, SD1: 16.3 },
  { observedHeight: 100, SD1neg: 14, SD0: 15.2, SD1: 16.5 },
  { observedHeight: 100.5, SD1neg: 14.1, SD0: 15.3, SD1: 16.6 },
  { observedHeight: 101, SD1neg: 14.2, SD0: 15.4, SD1: 16.8 },
  { observedHeight: 101.5, SD1neg: 14.4, SD0: 15.6, SD1: 16.9 },
  { observedHeight: 102, SD1neg: 14.5, SD0: 15.7, SD1: 17.1 },
  { observedHeight: 102.5, SD1neg: 14.6, SD0: 15.9, SD1: 17.3 },
  { observedHeight: 103, SD1neg: 14.8, SD0: 16, SD1: 17.4 },
  { observedHeight: 103.5, SD1neg: 14.9, SD0: 16.2, SD1: 17.6 },
  { observedHeight: 104, SD1neg: 15, SD0: 16.3, SD1: 17.8 },
  { observedHeight: 104.5, SD1neg: 15.2, SD0: 16.5, SD1: 17.9 },
  { observedHeight: 105, SD1neg: 15.3, SD0: 16.6, SD1: 18.1 },
  { observedHeight: 105.5, SD1neg: 15.4, SD0: 16.8, SD1: 18.3 },
  { observedHeight: 106, SD1neg: 15.6, SD0: 16.9, SD1: 18.5 },
  { observedHeight: 106.5, SD1neg: 15.7, SD0: 17.1, SD1: 18.6 },
  { observedHeight: 107, SD1neg: 15.9, SD0: 17.3, SD1: 18.8 },
  { observedHeight: 107.5, SD1neg: 16, SD0: 17.4, SD1: 19 },
  { observedHeight: 108, SD1neg: 16.2, SD0: 17.6, SD1: 19.2 },
  { observedHeight: 108.5, SD1neg: 16.3, SD0: 17.8, SD1: 19.4 },
  { observedHeight: 109, SD1neg: 16.5, SD0: 17.9, SD1: 19.6 },
  { observedHeight: 109.5, SD1neg: 16.6, SD0: 18.1, SD1: 19.8 },
  { observedHeight: 110, SD1neg: 16.8, SD0: 18.3, SD1: 20 }
];

const maleWeightForHeightReferenceData24To60 = [
  { observedHeight: 65, SD1neg: 6.9, SD0: 7.4, SD1: 8.1 },
  { observedHeight: 65.5, SD1neg: 7, SD0: 7.6, SD1: 8.2 },
  { observedHeight: 66, SD1neg: 7.1, SD0: 7.7, SD1: 8.3 },
  { observedHeight: 66.5, SD1neg: 7.2, SD0: 7.8, SD1: 8.5 },
  { observedHeight: 67, SD1neg: 7.3, SD0: 7.9, SD1: 8.6 },
  { observedHeight: 67.5, SD1neg: 7.4, SD0: 8, SD1: 8.7 },
  { observedHeight: 68, SD1neg: 7.5, SD0: 8.1, SD1: 8.8 },
  { observedHeight: 68.5, SD1neg: 7.6, SD0: 8.2, SD1: 9 },
  { observedHeight: 69, SD1neg: 7.7, SD0: 8.4, SD1: 9.1 },
  { observedHeight: 69.5, SD1neg: 7.8, SD0: 8.5, SD1: 9.2 },
  { observedHeight: 70, SD1neg: 7.9, SD0: 8.6, SD1: 9.3 },
  { observedHeight: 70.5, SD1neg: 8, SD0: 8.7, SD1: 9.5 },
  { observedHeight: 71, SD1neg: 8.1, SD0: 8.8, SD1: 9.6 },
  { observedHeight: 71.5, SD1neg: 8.2, SD0: 8.9, SD1: 9.7 },
  { observedHeight: 72, SD1neg: 8.3, SD0: 9, SD1: 9.8 },
  { observedHeight: 72.5, SD1neg: 8.4, SD0: 9.1, SD1: 9.9 },
  { observedHeight: 73, SD1neg: 8.5, SD0: 9.2, SD1: 10 },
  { observedHeight: 73.5, SD1neg: 8.6, SD0: 9.3, SD1: 10.2 },
  { observedHeight: 74, SD1neg: 8.7, SD0: 9.4, SD1: 10.3 },
  { observedHeight: 74.5, SD1neg: 8.8, SD0: 9.5, SD1: 10.4 },
  { observedHeight: 75, SD1neg: 8.9, SD0: 9.6, SD1: 10.5 },
  { observedHeight: 75.5, SD1neg: 9, SD0: 9.7, SD1: 10.6 },
  { observedHeight: 76, SD1neg: 9.1, SD0: 9.8, SD1: 10.7 },
  { observedHeight: 76.5, SD1neg: 9.2, SD0: 9.9, SD1: 10.8 },
  { observedHeight: 77, SD1neg: 9.2, SD0: 10, SD1: 10.9 },
  { observedHeight: 77.5, SD1neg: 9.3, SD0: 10.1, SD1: 11 },
  { observedHeight: 78, SD1neg: 9.4, SD0: 10.2, SD1: 11.1 },
  { observedHeight: 78.5, SD1neg: 9.5, SD0: 10.3, SD1: 11.2 },
  { observedHeight: 79, SD1neg: 9.6, SD0: 10.4, SD1: 11.3 },
  { observedHeight: 79.5, SD1neg: 9.7, SD0: 10.5, SD1: 11.4 },
  { observedHeight: 80, SD1neg: 9.7, SD0: 10.6, SD1: 11.5 },
  { observedHeight: 80.5, SD1neg: 9.8, SD0: 10.7, SD1: 11.6 },
  { observedHeight: 81, SD1neg: 9.9, SD0: 10.8, SD1: 11.7 },
  { observedHeight: 81.5, SD1neg: 10, SD0: 10.9, SD1: 11.8 },
  { observedHeight: 82, SD1neg: 10.1, SD0: 11, SD1: 11.9 },
  { observedHeight: 82.5, SD1neg: 10.2, SD0: 11.1, SD1: 12.1 },
  { observedHeight: 83, SD1neg: 10.3, SD0: 11.2, SD1: 12.2 },
  { observedHeight: 83.5, SD1neg: 10.4, SD0: 11.3, SD1: 12.3 },
  { observedHeight: 84, SD1neg: 10.5, SD0: 11.4, SD1: 12.4 },
  { observedHeight: 84.5, SD1neg: 10.7, SD0: 11.5, SD1: 12.5 },
  { observedHeight: 85, SD1neg: 10.8, SD0: 11.7, SD1: 12.7 },
  { observedHeight: 85.5, SD1neg: 10.9, SD0: 11.8, SD1: 12.8 },
  { observedHeight: 86, SD1neg: 11, SD0: 11.9, SD1: 12.9 },
  { observedHeight: 86.5, SD1neg: 11.1, SD0: 12, SD1: 13.1 },
  { observedHeight: 87, SD1neg: 11.2, SD0: 12.2, SD1: 13.2 },
  { observedHeight: 87.5, SD1neg: 11.3, SD0: 12.3, SD1: 13.3 },
  { observedHeight: 88, SD1neg: 11.5, SD0: 12.4, SD1: 13.5 },
  { observedHeight: 88.5, SD1neg: 11.6, SD0: 12.5, SD1: 13.6 },
  { observedHeight: 89, SD1neg: 11.7, SD0: 12.6, SD1: 13.7 },
  { observedHeight: 89.5, SD1neg: 11.8, SD0: 12.8, SD1: 13.9 },
  { observedHeight: 90, SD1neg: 11.9, SD0: 12.9, SD1: 14 },
  { observedHeight: 90.5, SD1neg: 12, SD0: 13, SD1: 14.1 },
  { observedHeight: 91, SD1neg: 12.1, SD0: 13.1, SD1: 14.2 },
  { observedHeight: 91.5, SD1neg: 12.2, SD0: 13.2, SD1: 14.4 },
  { observedHeight: 92, SD1neg: 12.3, SD0: 13.4, SD1: 14.5 },
  { observedHeight: 92.5, SD1neg: 12.4, SD0: 13.5, SD1: 14.6 },
  { observedHeight: 93, SD1neg: 12.6, SD0: 13.6, SD1: 14.7 },
  { observedHeight: 93.5, SD1neg: 12.7, SD0: 13.7, SD1: 14.9 },
  { observedHeight: 94, SD1neg: 12.8, SD0: 13.8, SD1: 15 },
  { observedHeight: 94.5, SD1neg: 12.9, SD0: 13.9, SD1: 15.1 },
  { observedHeight: 95, SD1neg: 13, SD0: 14.1, SD1: 15.3 },
  { observedHeight: 95.5, SD1neg: 13.1, SD0: 14.2, SD1: 15.4 },
  { observedHeight: 96, SD1neg: 13.2, SD0: 14.3, SD1: 15.5 },
  { observedHeight: 96.5, SD1neg: 13.3, SD0: 14.4, SD1: 15.7 },
  { observedHeight: 97, SD1neg: 13.4, SD0: 14.6, SD1: 15.8 },
  { observedHeight: 97.5, SD1neg: 13.6, SD0: 14.7, SD1: 15.9 },
  { observedHeight: 98, SD1neg: 13.7, SD0: 14.8, SD1: 16.1 },
  { observedHeight: 98.5, SD1neg: 13.8, SD0: 14.9, SD1: 16.2 },
  { observedHeight: 99, SD1neg: 13.9, SD0: 15.1, SD1: 16.4 },
  { observedHeight: 99.5, SD1neg: 14, SD0: 15.2, SD1: 16.5 },
  { observedHeight: 100, SD1neg: 14.2, SD0: 15.4, SD1: 16.7 },
  { observedHeight: 100.5, SD1neg: 14.3, SD0: 15.5, SD1: 16.9 },
  { observedHeight: 101, SD1neg: 14.4, SD0: 15.6, SD1: 17 },
  { observedHeight: 101.5, SD1neg: 14.5, SD0: 15.8, SD1: 17.2 },
  { observedHeight: 102, SD1neg: 14.7, SD0: 15.9, SD1: 17.3 },
  { observedHeight: 102.5, SD1neg: 14.8, SD0: 16.1, SD1: 17.5 },
  { observedHeight: 103, SD1neg: 14.9, SD0: 16.2, SD1: 17.7 },
  { observedHeight: 103.5, SD1neg: 15.1, SD0: 16.4, SD1: 17.8 },
  { observedHeight: 104, SD1neg: 15.2, SD0: 16.5, SD1: 18 },
  { observedHeight: 104.5, SD1neg: 15.4, SD0: 16.7, SD1: 18.2 },
  { observedHeight: 105, SD1neg: 15.5, SD0: 16.8, SD1: 18.4 },
  { observedHeight: 105.5, SD1neg: 15.6, SD0: 17, SD1: 18.5 },
  { observedHeight: 106, SD1neg: 15.8, SD0: 17.2, SD1: 18.7 },
  { observedHeight: 106.5, SD1neg: 15.9, SD0: 17.3, SD1: 18.9 },
  { observedHeight: 107, SD1neg: 16.1, SD0: 17.5, SD1: 19.1 },
  { observedHeight: 107.5, SD1neg: 16.2, SD0: 17.7, SD1: 19.3 },
  { observedHeight: 108, SD1neg: 16.4, SD0: 17.8, SD1: 19.5 },
  { observedHeight: 108.5, SD1neg: 16.5, SD0: 18, SD1: 19.7 },
  { observedHeight: 109, SD1neg: 16.7, SD0: 18.2, SD1: 19.8 },
  { observedHeight: 109.5, SD1neg: 16.8, SD0: 18.3, SD1: 20 },
  { observedHeight: 110, SD1neg: 17, SD0: 18.5, SD1: 20.2 },
  { observedHeight: 110.5, SD1neg: 17.1, SD0: 18.7, SD1: 20.4 },
  { observedHeight: 111, SD1neg: 17.3, SD0: 18.9, SD1: 20.7 },
  { observedHeight: 111.5, SD1neg: 17.5, SD0: 19.1, SD1: 20.9 },
  { observedHeight: 112, SD1neg: 17.6, SD0: 19.2, SD1: 21.1 },
  { observedHeight: 112.5, SD1neg: 17.8, SD0: 19.4, SD1: 21.3 },
  { observedHeight: 113, SD1neg: 18, SD0: 19.6, SD1: 21.5 },
  { observedHeight: 113.5, SD1neg: 18.1, SD0: 19.8, SD1: 21.7 },
  { observedHeight: 114, SD1neg: 18.3, SD0: 20, SD1: 21.9 },
  { observedHeight: 114.5, SD1neg: 18.5, SD0: 20.2, SD1: 22.1 },
  { observedHeight: 115, SD1neg: 18.6, SD0: 20.4, SD1: 22.4 },
  { observedHeight: 115.5, SD1neg: 18.8, SD0: 20.6, SD1: 22.6 },
  { observedHeight: 116, SD1neg: 19, SD0: 20.8, SD1: 22.8 },
  { observedHeight: 116.5, SD1neg: 19.2, SD0: 21, SD1: 23 },
  { observedHeight: 117, SD1neg: 19.3, SD0: 21.2, SD1: 23.3 },
  { observedHeight: 117.5, SD1neg: 19.5, SD0: 21.4, SD1: 23.5 },
  { observedHeight: 118, SD1neg: 19.7, SD0: 21.6, SD1: 23.7 },
  { observedHeight: 118.5, SD1neg: 19.9, SD0: 21.8, SD1: 23.9 },
  { observedHeight: 119, SD1neg: 20, SD0: 22, SD1: 24.1 },
  { observedHeight: 119.5, SD1neg: 20.2, SD0: 22.2, SD1: 24.4 },
  { observedHeight: 120, SD1neg: 20.4, SD0: 22.4, SD1: 24.6 }
];

const calculateZScore = (age, observedWeight, sex) => {
  const referenceData = sex === "male" ? maleReferenceData : femaleReferenceData;
  const reference = referenceData.find((data) => data.age === age);
  if (!reference) return 'Data not available'; 

  const median = reference.SD0;
  let sdInterval;

  if (observedWeight < median) {
    sdInterval = median - reference.SD1neg;
  } else {
    sdInterval = reference.SD1 - median;
  }

  return (observedWeight - median) / sdInterval;
};

const calculateHeightForAgeZScore = (age, observedHeight, sex) => {
  const hReferenceData = sex === "male" ? maleHeightReferenceData : femaleHeightReferenceData;
  const hReference = hReferenceData.find((data) => data.age === age);
  if (!hReference) return 'Data not available'; 

  const medianHeight = hReference.SD0;
  let heightSdInterval;

  if (observedHeight < medianHeight) {
    heightSdInterval = medianHeight - hReference.SD1neg;
  } else {
    heightSdInterval = hReference.SD1 - medianHeight;
  }

  return (observedHeight - medianHeight) / heightSdInterval;
};

const calculateWHZ = (age, observedHeight, observedWeight, sex) => {
  const referenceDataWHZ =
    age < 23
      ? sex === "male"
        ? maleWeightForHeightReferenceData
        : femaleWeightForHeightReferenceData
      : sex === "male"
      ? maleWeightForHeightReferenceData24To60
      : femaleWeightForHeightReferenceData24To60;

  const referenceWHZ = referenceDataWHZ.find((data) => data.observedHeight === observedHeight);
  if (!referenceWHZ) {
    return observedHeight > referenceDataWHZ[referenceDataWHZ.length - 1].observedHeight ? 3 : -4;
  }

  const medianWHZ = referenceWHZ.SD0;
  const sdIntervalWHZ = referenceWHZ.SD1 - medianWHZ;

  return (observedWeight - medianWHZ) / sdIntervalWHZ;
};

const classifyHeightForAgeZScore = computed(() => {
  if (form.value.zScoreHeight < -3) return 'Severely Stunted';
  if (form.value.zScoreHeight >= -3 && form.value.zScoreHeight < -2) return 'Stunted';
  if (form.value.zScoreHeight >= -2 && form.value.zScoreHeight <= 2) return 'Normal';
  return 'Tall';
});

const classification = computed(() => {
  if (form.value.zScore < -3) return 'Severely Underweight';
  if (form.value.zScore >= -3 && form.value.zScore < -2) return 'Underweight';
  if (form.value.zScore >= -2 && form.value.zScore <= 2) return 'Normal Weight';
  return 'Overweight';
});

const WFHclassification = computed(() => {
  if (form.value.WFHzScore < -3) return 'Severely Wasted';
  if (form.value.WFHzScore >= -3 && form.value.WFHzScore < -2) return 'Moderately Wasted';
  if (form.value.WFHzScore >= -2 && form.value.WFHzScore <= 2) return 'Normal Weight';
  if (form.value.WFHzScore > 2 && form.value.WFHzScore <= 3) return 'Overweight';
  return 'Obese';
});
const onSubmit = async () => {
  form.value.zScore = calculateZScore(form.value.age, form.value.weight, form.value.sex);
  form.value.zScoreHeight = calculateHeightForAgeZScore(form.value.age, form.value.height, form.value.sex);
  form.value.WFHzScore = calculateWHZ(form.value.age, form.value.height, form.value.weight, form.value.sex);

  try {
    await axios.post(`/child/${props.child.id}/addGrowthMonitoring`, {
      sex: form.value.sex,
      age: form.value.age,
      weight: form.value.weight,
      height: form.value.height,
      zScore: form.value.zScore,
      zScoreHeight: form.value.zScoreHeight,
      WFHzScore: form.value.WFHzScore,
      classification: classification.value,
      classifyHeightForAgeZScore: classifyHeightForAgeZScore.value,
      WFHclassification: WFHclassification.value
    });
    alert('Data saved successfully');
  } catch (error) {
    console.error('Error saving data:', error);
    alert(`Failed to save data: ${error.response?.data?.message || error.message}`);
  }
};
</script>

<template>
  <div>
    <h1>Weight-for-Age Z-Score Calculator</h1>

    <form @submit.prevent="onSubmit">
      <label for="sex">Sex:</label>
      <select id="sex" v-model="form.sex">
        <option value="male">Male</option>
        <option value="female">Female</option>
      </select>

      <label for="age">Age (months):</label>
      <input type="number" id="age" v-model.number="form.age" min="0" max="60" required />

      <label for="weight">Weight (kg):</label>
      <input type="number" id="weight" v-model.number="form.weight" step="0.01" required />

      <label for="height">Height (cm):</label>
      <input type="number" id="height" v-model.number="form.height" step="0.01" required />

      <button type="submit">Save</button>
    </form>
  </div>
</template>


<style scoped>
form {
  display: flex;
  flex-direction: column;
  gap: 1rem;
  max-width: 300px;
  margin: auto;
}

button {
  padding: 0.5rem;
  background-color: #007bff;
  color: white;
  border: none;
  cursor: pointer;
  border-radius: 5px;
}

button:hover {
  background-color: #0056b3;
}
</style>
