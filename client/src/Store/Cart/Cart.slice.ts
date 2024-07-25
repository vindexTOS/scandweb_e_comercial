import { createSlice, PayloadAction } from "@reduxjs/toolkit";

const initialState: any = {
  product: {},
  cartProducts: [],
  showCart: false,
};

const CartSlice = createSlice({
  name: "cart",
  initialState,
  reducers: {
    addToCart: (state, action) => {
      state.cartProducts = [...state.cartProducts, action.payload];
    },
    addArrayToCart: (state, action) => {
      state.cartProducts = action.payload;
    },
    handleShowCart: (state) => {
      state.showCart = !state.showCart;
    },
  },
});
export const { addToCart, addArrayToCart } = CartSlice.actions;
export default CartSlice.reducer;
