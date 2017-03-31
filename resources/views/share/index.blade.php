@extends('master')

@section('content')

    <section id="cloud">
        <header>
            <h1>Meine Freigaben</h1>
        </header>
        <md-layout id="my-shares" md-gutter>
            <md-layout>
                <md-list class="md-double-line">
                    @foreach($fileShares as $fileShare)
                        <md-list-item data-fileshare-hash="{{ $fileShare->hash }}">
                            <md-button href="{{ route('share.show', $fileShare->hash) }}" target="_blank" class="md-icon-button share-button" md-theme="inverted">
                                <md-icon>share</md-icon>
                            </md-button>

                            <div class="md-list-text-container">
                                <a href="{{ route('share.show', $fileShare->hash) }}" target="_blank">
                                    Freigabe vom {{ Carbon\Carbon::parse($fileShare->created_at)->format('d.m.Y, H:i') }}
                                </a>

                                <?php $count = count(json_decode($fileShare->files)); ?>
                                <span>
                                    {{ $count }}
                                    @if($count == 1) Datei @else Dateien @endif
                                </span>
                            </div>

                            <md-button class="md-icon-button md-list-action delete-file-share" @click.native="deleteShareByHash('{{ $fileShare->hash }}')">
                                <md-icon>delete</md-icon>
                            </md-button>

                            @if(! $loop->last)
                                <md-divider class="md-inset"></md-divider>
                            @endif
                        </md-list-item>
                    @endforeach
              </md-list>
            </md-layout>
        </md-layout>
    </section>

@stop