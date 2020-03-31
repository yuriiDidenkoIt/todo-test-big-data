import React from "react";
import { useSelector, useDispatch } from 'react-redux';
import FilterOrderButton from './Atoms/FilterOrderButton';
import { setFilter } from '../redux/actions';
import { getVisibilityFilter } from '../redux/selectors';
import { VISIBILITY_FILTERS } from '../constants';

import './VisibilityFilters.css';

const VisibilityFilters = () => {
    const activeFilter = useSelector(getVisibilityFilter)
    const dispatch = useDispatch()
    return (
        <div className="visibility-filters">
            {Object.keys(VISIBILITY_FILTERS).map(filterKey => {
                const currentFilter = VISIBILITY_FILTERS[filterKey];
                return (
                    <FilterOrderButton
                        title={currentFilter}
                        isActive={currentFilter === activeFilter}
                        key={`visibility-filter-${currentFilter}`}
                        onClick={() => dispatch(setFilter(currentFilter))}
                    />
                );
            })}
        </div>
    );
};

export default VisibilityFilters;