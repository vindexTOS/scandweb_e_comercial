import { createAsyncThunk } from "@reduxjs/toolkit";
import { fetchGraphql } from "../../Request/Graphql";

 export const postOrder :any = createAsyncThunk("order/post", 
  async ( product_id:string , selectedAttributes:any  ) => {
 

   const queryString = `
      mutation ($orderInput: OrderInput!, $attributesInput: [OrderAttributeInput!]!) {
        createOrder(orderInput: $orderInput, attributesInput: $attributesInput) {
          order {
            id
            product_id
            attributes {
              key
              value
            }
          }
        }
      }
    `;
    console.log(selectedAttributes)

    // Construct the variables object dynamically
    const variables = {
      orderInput: {
        product_id
      },
      attributesInput: Object.entries(selectedAttributes).map(([key, value]) => ({
        key,
        value
      }))
    };
    // Serialize the query and variables into a JSON string
    const requestBody = JSON.stringify({
      query: queryString,
      variables
    });

    try {
      // Pass the serialized request body as a single string
      const data = await fetchGraphql(requestBody);
      console.log(data);
      return data;
    } catch (error) {
        console.log(error)
      throw new Error("Failed to make order");
    }
  }
);
