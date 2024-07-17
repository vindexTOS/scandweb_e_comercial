import { createAsyncThunk } from "@reduxjs/toolkit";
import { fetchGraphql } from "../../Request/Graphql";

export const fetchProducts: any = createAsyncThunk(
  "products/fetchProducts",
  async (query: string) => {
    try {
      const data: any = await fetchGraphql(query);
      console.log(data);
      return data.products;
    } catch (error) {
      throw new Error("Failed to fetch products");
    }
  }
);
