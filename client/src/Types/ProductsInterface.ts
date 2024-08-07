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
  product_id:number | string
}

interface ProductsData {
  data: {
    products: Product[];
  };
}

interface CartProductMetaData {
  selectedAttrabutes?:any
  storageID?:string 
  count?:number
}
interface CartProductType  extends CartProductMetaData{
  name: string;
  description: string;
  attributes: Attribute[];
  prices: Price[];
  id: string;
 photo:string 
 product_id:number | string

}
export type {
  Product,
  Price,
  Currency,
  ProductsData,
  Attribute,
  AttributeItem,
  CartProductType,
};
