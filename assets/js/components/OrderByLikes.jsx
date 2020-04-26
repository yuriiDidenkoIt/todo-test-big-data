import React from "react";
import { useSelector, useDispatch } from "react-redux";
import { setOderByLikes } from "../redux/actions";
import FilterOrderButton from "./Atoms/FilterOrderButton";
import { ORDER_BY_LIKES } from "../constants";
import { getActiveOrderByLikes } from "../redux/selectors";

import './VisibilityFilters.css';

const OrderByLikes = () => {
    const activeOrder = useSelector(getActiveOrderByLikes);
    const dispatch = useDispatch()
    return (
        <div className="visibility-filters">
            {Object.keys(ORDER_BY_LIKES).map(orderKey => {
                const currentOrder = ORDER_BY_LIKES[orderKey];
                const orderToSet = currentOrder !== activeOrder ? currentOrder : activeOrder;
                return (
                    <FilterOrderButton
                        title={currentOrder}
                        isActive={currentOrder === activeOrder}
                        key={`visibility-filter-${currentOrder}`}
                        onClick={() => dispatch(setOderByLikes(orderToSet))}
                    />
                );
            })}
        </div>
    );
};

export default OrderByLikes;