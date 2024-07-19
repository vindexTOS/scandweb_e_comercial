import { createSlice } from "@reduxjs/toolkit";
import { fetchCategories } from "./Categories.thunk";
import { CategoriesState } from "../../Types/CategoriesInterface";

const initialState: CategoriesState = {
  navItems: [],
  status: "idle",
  error: null,
  currentCategory: {
    name: "all",
    id: "1",
  },
};

const categoriesSlice = createSlice({
  name: "categories",
  initialState,
  reducers: {
    getCategory: (state, action) => {
      state.currentCategory = action.payload;
    },
  },
  extraReducers: (builder) => {
    builder
      .addCase(fetchCategories.pending, (state) => {
        state.status = "loading";
        state.error = null;
      })
      .addCase(fetchCategories.fulfilled, (state, action) => {
        state.status = "succeeded";
        state.navItems = action.payload;
      })
      .addCase(fetchCategories.rejected, (state, action) => {
        state.status = "failed";
        state.error = action.error.message || "Failed to fetch categories";
      });
  },
});

export default categoriesSlice.reducer;
export const { getCategory } = categoriesSlice.actions;
