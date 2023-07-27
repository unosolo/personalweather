import type { PeriodDto } from "./PeriodDto";

export interface WeatherForecastDto {
  id: number;
  periods: PeriodDto[];
}
