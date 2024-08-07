import { createAsyncThunk } from '@reduxjs/toolkit';
import {  fetchPostRequest } from '../../Request/Graphql';

export const postOrder:any = createAsyncThunk('order/post', async ( {product_id  , attributes  }:{product_id:string , attributes :any}) => {
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

   const id = Number(product_id);
  const attributesInput:any = attributes;
 console.log(attributesInput)
  // Construct the variables object
  const variables = {
    orderInput: {
      product_id:id
    },
    attributesInput 
  };
 
  // Serialize the query and variables into a JSON string
  const requestBody = JSON.stringify({
    query: queryString,
    variables
  });

  try {
    // Pass the serialized request body as a single string
    const data = await fetchPostRequest (requestBody);
    console.log(data);
    return data;
  } catch (error) {
    console.log(error);
    throw new Error('Failed to make order');
  }
});