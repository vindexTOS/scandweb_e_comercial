import { configureStore } from "@reduxjs/toolkit";
import categoriesReducer from "../Store/Categories/Categories.slice";
import productsReducer from "../Store/Products/Products.slice";
import cartReducer from "../Store/Cart/Cart.slice";
const store = configureStore({
  reducer: {
    categories: categoriesReducer,
    products: productsReducer,
    cart: cartReducer,
  },
  middleware: (getDefaultMiddleware) =>
    getDefaultMiddleware({
      serializableCheck: {
    
        ignoredActions: ['cart/addToCart'],
        ignoredActionPaths: ['payload.handleCart'],
        ignoredPaths: ['cart.cartProducts'],
      },
    }),
});

export default store;

