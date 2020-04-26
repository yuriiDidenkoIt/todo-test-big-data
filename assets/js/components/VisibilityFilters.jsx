import React from "react";
import { useSelector, useDispatch } from 'react-redux';
import FilterOrderButton from './Atoms/FilterOrderButton';
import { setFilter } from '../redux/actions';
import { getActiveFilter, getFiltersCounts } from '../redux/selectors';
import { VISIBILITY_FILTERS } from '../constants';

import './VisibilityFilters.css';

const VisibilityFilters = () => {
    const activeFilter = useSelector(getActiveFilter);
    const filtersCounts = useSelector(getFiltersCounts);
    const dispatch = useDispatch();
    return (
        <div className="visibility-filters">
            {Object.keys(VISIBILITY_FILTERS).map(filterKey => {
                const currentFilter = `${VISIBILITY_FILTERS[filterKey]} (${filtersCounts[filterKey]})`;
                return (
                    <FilterOrderButton
                        title={currentFilter}
                        isActive={+filterKey === activeFilter}
                        key={`visibility-filter-${currentFilter}`}
                        onClick={() => dispatch(setFilter(+filterKey))}
                    />
                );
            })}
        </div>
    );
};

export default VisibilityFilters;