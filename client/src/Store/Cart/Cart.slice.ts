import { createSlice, PayloadAction } from "@reduxjs/toolkit";
import { CartProductType } from "../../Types/ProductsInterface";
import { postOrder } from "./Cart.thunk";
import { StatusType } from "../../Types/StatusInterface";

interface CartState {
  cartProducts: CartProductType[];
  showCart: boolean;
  attrabuteSelector: { [key: string]: any };
  status: StatusType;
  error: null;
}

const initialState: CartState = {
  cartProducts: [],
  showCart: false,
  attrabuteSelector: {},
  status: "idle",
  error: null,
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
    handleShowCart: (state, action) => {
      state.showCart = action.payload;
    },
  handleStatus:(state )=>{
      state.status = 'idle'
  },
    handleAttrabuteSelector: (
      state,
      action: PayloadAction<{ key: string; value: any }>
    ) => {
      state.attrabuteSelector[action.payload.key] = action.payload.value;
    },
    handleClearAttrabutesSelector: (state) => {
      state.attrabuteSelector = {};
    },
  },
  extraReducers: (builder) => {
    builder
      .addCase(postOrder.pending, (state) => {
        state.status = "loading";
      })
      .addCase(postOrder.fulfilled, (state, action) => {
        state.status = "succeeded";
         state. attrabuteSelector = {}
         state.cartProducts = []
    
         localStorage.removeItem("cart-product")
      })
      .addCase(postOrder.rejected, (state, action) => {
        state.status = "failed";
        state.error = action.payload;
      });
  },
});

export const {
  addToCart,
  addArrayToCart,
  handleShowCart,
  handleAttrabuteSelector,
  handleClearAttrabutesSelector,handleStatus
} = CartSlice.actions;
export default CartSlice.reducer;
