import { createSlice, PayloadAction } from "@reduxjs/toolkit";

const initialState: any = {
  product: {},
  cartProducts: [],
};

const CartSlice = createSlice({
  name: "cart",
  initialState,
  reducers: {
    addToCart: (state, action) => {
      state.cartProducts = [...state.cartProducts, action.payload];
    },
  },
});
export const { addToCart } = CartSlice.actions;
export default CartSlice.reducer;
