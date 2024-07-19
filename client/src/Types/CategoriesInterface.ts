export interface Category {
  id: string;
  name: string;
  __typename?: string;
}

export interface CategoriesState {
  navItems: Category[];
  status: "idle" | "loading" | "succeeded" | "failed";
  error: string | null;
  currentCategory: Category;
}
