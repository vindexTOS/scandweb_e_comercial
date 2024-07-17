interface Currency {
  label: string;
  symbol: string;
}

interface Price {
  id: string;
  amount: number;
  currency: Currency;
}

interface AttributeItem {
  id: string;
  displayValue: string;
  value: string;
}

interface Attribute {
  id: string;
  name: string;
  type: string;
  items: AttributeItem[];
}

interface Product {
  id: string;
  name: string;
  inStock: boolean;
  gallery: string[];
  description: string;
  category: string;
  attributes: Attribute[];
  prices: Price[];
}

interface ProductsData {
  data: {
    products: Product[];
  };
}

export type {
  Product,
  Price,
  Currency,
  ProductsData,
  Attribute,
  AttributeItem,
};
