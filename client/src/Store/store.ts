import { configureStore } from "@reduxjs/toolkit";
import categoriesReducer from "../Store/Categories/Categories.slice";
import productsReducer from "../Store/Products/Products.slice";

const store = configureStore({
  reducer: {
    categories: categoriesReducer,
    products: productsReducer,
  },
});

export default store;
