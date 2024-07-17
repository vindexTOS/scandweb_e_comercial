export interface Category {
  id: string;
  name: string;
  __typename: string;
}

export interface CategoriesState {
  navItems: Category[];
  loading: boolean;
  error: string | null;
}
