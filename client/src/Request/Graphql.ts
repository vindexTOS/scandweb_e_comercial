import { request, gql } from "graphql-request";
export const fetchGraphql = async (queryString: string) => {
  const endpoint = "http://138.197.229.66/graphql";
  const query = gql`
    ${queryString}
  `;

  try {
    const data = await request(endpoint, query);
    return data;
  } catch (error) {
    console.error("GraphQL request error:", error);
    throw new Error("Failed to fetch GraphQL data");
  }
};

 
export const fetchPostRequest = async (requestBody:any) => {
  const endpoint = 'http://138.197.229.66/graphql';
  
  try {
    const response = await fetch(endpoint, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: requestBody
    });

    const data = await response.json();

    if (response.ok) {
      return data;
    } else {
      throw new Error(data.errors.map(error => error.message).join(', '));
    }
  } catch (error) {
    console.error('GraphQL request error:', error);
    throw new Error('Failed to fetch GraphQL data');
  }
};