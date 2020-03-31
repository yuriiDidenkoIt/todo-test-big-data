import { combineReducers } from "redux";
import visibilityFilter from "./visibilityFilter";
import todos from "./todos";
import pagination from "./pagination";
import orderByLikes from "./orderByLikes";

export default combineReducers({ todos, visibilityFilter, pagination, orderByLikes });