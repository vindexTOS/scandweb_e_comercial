import { ErrorType, StatusType } from "./StatusInterface";

export interface Category {
  id: string;
  name: string;
  __typename?: string;
}

export interface CategoriesState {
  navItems: Category[];
  status: StatusType;
  error: ErrorType;
  currentCategory: Category;
}
