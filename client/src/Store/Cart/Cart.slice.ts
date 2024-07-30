import { createSlice, PayloadAction } from "@reduxjs/toolkit";
import { CartProductType } from '../../Types/ProductsInterface';

interface CartState {
  cartProducts: CartProductType[];
  showCart: boolean;
  attrabuteSelector: { [key: string]: any };
}

const initialState: CartState = {
  cartProducts: [],
  showCart: false,
  attrabuteSelector: {}
};

const CartSlice = createSlice({
  name: "cart",
  initialState,
  reducers: {
    addToCart: (state, action: PayloadAction<CartProductType>) => {
      state.cartProducts.push(action.payload);
    },
    addArrayToCart: (state, action: PayloadAction<CartProductType[]>) => {
      state.cartProducts = action.payload;
    },
    handleShowCart: (state,action) => {
      state.showCart = action.payload;
    },
  
    handleAttrabuteSelector: (state, action: PayloadAction<{ key: string, value: any }>) => {
      state.attrabuteSelector[action.payload.key] = action.payload.value;
    },
    handleClearAttrabutesSelector: (state) => {
      state.attrabuteSelector = {};
    }
  },
});

export const { addToCart, addArrayToCart, handleShowCart, handleAttrabuteSelector, handleClearAttrabutesSelector } = CartSlice.actions;
export default CartSlice.reducer;
