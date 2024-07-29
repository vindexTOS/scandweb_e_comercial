import { createSlice, PayloadAction } from "@reduxjs/toolkit";

const initialState: any = {
  product: {},
  cartProducts: [],
  showCart: false,
  attrabuteSelector:{}
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
    handleAttrabuteSelector:(state,action)=>{
  
        state.attrabuteSelector[action.payload.key] = action.payload.value
    }
  },
});
export const { addToCart, addArrayToCart,handleShowCart, handleAttrabuteSelector } = CartSlice.actions;
export default CartSlice.reducer;
