import { request, gql } from "graphql-request";
export const fetchGraphql = async (queryString: string) => {
  const endpoint = "http://localhost:7000/graphql";
  const query = gql`
    ${queryString}
  `;

  try {
    const data = await request(endpoint, query);
    return data; // Return the data
  } catch (error) {
    console.error("GraphQL request error:", error);
    throw new Error("Failed to fetch GraphQL data");
  }
};
