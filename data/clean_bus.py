# %%
import os
try:
    os.chdir(os.path.join(os.getcwd(), 'data'))
    print(os.getcwd())
except:
    pass

# %% Import all packages
import json
import pandas as pd
from pandas.io.json import json_normalize

# %% Import Data
stops = pd.read_csv('./raw/stops.csv')
trips = pd.read_csv('./raw/trips.csv')
stop_times = pd.read_csv('./raw/stop_times.csv')

# %% Merge stops into full_trips
full_trips = stop_times.merge(
    stops[['stop_lat', 'stop_lon', 'stop_id']], on='stop_id')
full_trips.head()


# %% Merge Route Info into full_trips
full_trips = full_trips.merge(trips[['trip_id', 'route_id']], on='trip_id')
full_trips.head()

# %% Define customized function


def validate_time(date_str):
    x = int(date_str.split(':', 1)[0])
    if x >= 24:
        print(x)
        return str(x-24) + date_str[2:]
    else:
        return date_str


# %% Convert the time format
full_trips['arrival_time'] = full_trips['arrival_time'].apply(validate_time)
full_trips['arrival_time'] = full_trips['arrival_time'].apply(
    lambda x: x.replace(' ', '0'))
full_trips['departure_time'] = full_trips['departure_time'].apply(
    validate_time)
full_trips['departure_time'] = full_trips['departure_time'].apply(
    lambda x: x.replace(' ', '0'))

# %%
full_trips['arrival_time'] = pd.to_datetime(
    full_trips['arrival_time'], format="%H:%M:%S").dt.time
full_trips['departure_time'] = pd.to_datetime(
    full_trips['departure_time'], format="%H:%M:%S").dt.time
full_trips.to_csv('./full_trips.csv', index=False)
