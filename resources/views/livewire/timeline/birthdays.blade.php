<div>
    <ul class="media-story list-inline m-0 p-0">
        @foreach ($birthdays as $ownr_b)
            <li class="d-flex mb-4 align-items-center">
                <img src="{{ $ownr_b->pic_profile }}" alt="Pic Profile {{ $ownr_b->username }}"
                    class="rounded-circle img-fluid">
                <div class="stories-data ms-3">
                    <h5>
                        <a href="/owner/{{ $ownr_b->username }}">{{ $ownr_b->username }}</a>
                    </h5>

                    @php
                        $birth = \Carbon\Carbon::parse($ownr_b->birthDate);
                        $today = \Carbon\Carbon::today();

                        // Próximo cumpleaños
                        $nextBirthday = $birth->copy()->year($today->year);

                        // Manejo de 29/02 en años no bisiestos
                        if ($birth->format('m-d') === '02-29' && !$nextBirthday->isLeapYear()) {
                            $nextBirthday->day(28);
                        }

                        // Si ya pasó este año, usamos el próximo año
                        if ($nextBirthday->lt($today)) {
                            $nextBirthday->addYear();
                            if ($birth->format('m-d') === '02-29' && !$nextBirthday->isLeapYear()) {
                                $nextBirthday->day(28);
                            }
                        }

                        // Días que faltan (entero)
                        $days = $today->diffInDays($nextBirthday, false);

                        // Edad que va a cumplir
                        $age = $nextBirthday->year - $birth->year;

                        // Mensaje final
                        if ($days == 0) {
                            $message = __('timeline.birthday_today', ['age' => $age]);
                        } elseif ($days == 1) {
                            $message = __('timeline.birthday_tomorrow', ['age' => $age]);
                        } else {
                            $message = __('timeline.birthday_days_left', [
                                'days' => $days,
                                'age' => $age,
                                'date' => $ownr_b->birthDate,
                            ]);
                        }
                    @endphp

                    <p class="mb-0">{{ $message }}</p>

                </div>
            </li>
        @endforeach
    </ul>
</div>
