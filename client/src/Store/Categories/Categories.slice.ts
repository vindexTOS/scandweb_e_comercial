import { createSlice } from "@reduxjs/toolkit";
import { fetchCategories } from "./Categories.thunk";
import { CategoriesState } from "../../Types/CategoriesInterface";

const initialState: CategoriesState = {
  navItems: [],
  loading: false,
  error: null,
  currentCategory: "all",
};

const categoriesSlice = createSlice({
  name: "categories",
  initialState,
  reducers: {
    getCategory: (state, action) => {
      return { ...state, currentCategory: action.payload };
    },
  },
  extraReducers: (builder) => {
    builder
      .addCase(fetchCategories.pending, (state) => {
        state.loading = true;
        state.error = null;
      })
      .addCase(fetchCategories.fulfilled, (state, action) => {
        state.loading = false;
        state.navItems = action.payload;
      })
      .addCase(fetchCategories.rejected, (state, action) => {
        state.loading = false;
        state.error = action.error.message || "Failed to fetch categories";
      });
  },
});

export default categoriesSlice.reducer;
export const { getCategory } = categoriesSlice.actions;
