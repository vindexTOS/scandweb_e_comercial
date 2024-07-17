import { createAsyncThunk } from "@reduxjs/toolkit";
import { fetchGraphql } from "../../Request/Graphql";

export const fetchCategories: any = createAsyncThunk(
  "categories/fetchCategories",
  async () => {
    try {
      const data: any = await fetchGraphql(
        "{ categories { name id __typename } }"
      );
      return data.categories;
    } catch (error) {
      throw new Error("Failed to fetch categories");
    }
  }
);
